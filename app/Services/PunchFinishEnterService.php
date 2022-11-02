<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Models\Holiday;
use App\Models\Employee;

class PunchFinishEnterService
{
    // 残業時間を算出・取得
    public function getOverTime($kintai, $working_time)
    {
        // 定時時間の分数を取得(平日なら450分(7.5)、土日祝なら390分(6.5))
        $regular_time = $this->getRegularTime($kintai->work_day);
        // 初期値として0を設定(パートは残業時間=0なのでこのまま)
        $over_time = 0;
        // 社員は残業時間を算出
        if($kintai->employee->employee_category_id == 1){
            // 稼働時間が定時時間に60分足した時間以上であれば残業時間発生(定時時間から1時間経過したら残業が発生する)
            if($working_time >= $regular_time + 1){
                $over_time = $working_time - $regular_time;
            }
        }
        return $over_time;
    }

    // 定時時間を算出・取得
    public function getRegularTime($work_day)
    {
        // 出勤日をインスタンス化してフォーマット
        $work_day = new Carbon($work_day);
        // 曜日番号から平日か土日かを判定
        // 1->月,2->火,3->水,4->木,5->金,6->土,7->日
        // 6よりも小さければ平日
        if($work_day->dayOfWeekIso < 6){
            // 平日用の定時時間をセット
            $regular_time = 7.5;
            // 祝日の可能性があるので、祝日マスタに存在する日付であるかチェック
            if(Holiday::where('holiday', $work_day)->exists()){
                // 存在した場合は、土日祝用の定時時間をセット
                $regular_time = 6.5;
            }
        }
        // 6以上なら土日
        if($work_day->dayOfWeekIso >= 6){
            $regular_time = 6.5;
        }
        return $regular_time;
    }

    // 退勤情報を勤怠テーブルに更新
    public function updatePunchFinishForKintai($request, $over_time)
    {
        Kintai::where('kintai_id', $request->kintai_id)->update([
            'finish_time' => $request->finish_time,
            'finish_time_adj' => $request->finish_time_adj,
            'rest_time' => $request->rest_time,
            'no_rest_time' => $request->no_rest_time,
            'working_time' => $request->working_time * 60, // 0.25単位から分単位に変換
            'over_time' => $over_time * 60, // 0.25単位から分単位に変換
        ]);
        return;
    }

    // 荷主稼働時間の情報を勤怠詳細テーブルに追加
    public function addPunchFinishForKintaiDetail($kintai_id, $working_time_input)
    {
        // 荷主稼働時間の要素分だけループ処理
        foreach($working_time_input as $key => $value){
            KintaiDetail::create([
                'kintai_detail_id' => $kintai_id.'-'.$key,
                'kintai_id' => $kintai_id,
                'customer_id' => $key,
                'customer_working_time' => $value * 60, // 0.25単位から分単位に変換
            ]);
        }
        return;
    }

    public function getWorkableHours($kintai)
    {
        // 月間稼働可能時間設定を取得
        $employee = Employee::where('employee_no', $kintai->employee_no)->first();
        $monthly_workable_time_setting = $employee->monthly_workable_time_setting;
        // 月初の日付を取得
        $start_day = Carbon::now()->startOfMonth()->toDateString();
        // 月末の日付を取得
        $end_day = Carbon::now()->endOfMonth()->toDateString();
        // 当月の稼働時間を算出(0.25単位に変換している)
        $total_month_working_time = (Kintai::where('employee_no', $kintai->employee_no)
                                    ->whereBetween('work_day', [$start_day, $end_day])
                                    ->sum('working_time')) / 60;
        // 定総労働時間 - 当月の稼働時間で労働可能時間を算出
        $workable_times = $monthly_workable_time_setting - $total_month_working_time;
        return compact('monthly_workable_time_setting', 'workable_times', 'total_month_working_time');
    }
}