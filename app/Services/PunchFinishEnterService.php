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
        // 定時時間を取得
        // 社員：平日なら450分(7.5)、土日祝なら390分(6.5)
        // パート：480分(8.0)
        $regular_time = $this->getRegularTime($kintai->work_day, $kintai->employee->employee_category_id);
        // 残業開始時間を取得
        $over_time_start = $this->getOverTimeStart($regular_time, $kintai->employee->employee_category_id, $kintai->employee->over_time_start_setting);
        // 初期値として0を設定
        $over_time = 0;
        // 稼働時間が残業開始時間を超えていたら残業発生
        if($working_time >= $over_time_start['over_time_start_1']){
            $over_time = $working_time - $over_time_start['over_time_start_2'];
        }
        return $over_time;
    }

    // 定時時間を算出・取得
    public function getRegularTime($work_day, $employee_category_id)
    {
        // 社員の場合
        if($employee_category_id == 1){
            // 出勤日をインスタンス化してフォーマット
            $work_day = new Carbon($work_day);
            // 曜日番号から平日か土日かを判定
            // 1->月, 2->火, 3->水, 4->木, 5->金, 6->土, 7->日
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
        }
        // パートの場合
        if($employee_category_id == 2){
            $regular_time = 8.0;
        }
        return $regular_time;
    }

    // 残業が発生する時間を取得
    public function getOverTimeStart($regular_time, $employee_category_id, $over_time_start_setting)
    {
        // $over_time_start_1 --- 残業時間を算出するかの判断に使用する時間
        // $over_time_start_2 --- 残業時間を算出する時に使用する時間

        // 残業開始時間設定が0.25以上であれば、設定を優先する
        if($over_time_start_setting >= 0.25){
            $over_time_start_1 = $over_time_start_setting;
            $over_time_start_2 = $over_time_start_setting;
        }
        if($over_time_start_setting < 0.25){
            // 社員は定時時間に1時間足した時間、パートは設定された時間
            $over_time_start_1 = $employee_category_id == 1 ? $regular_time + 1 : $regular_time;
            $over_time_start_2 = $regular_time;
        }
        return compact('over_time_start_1', 'over_time_start_2');
    }

    // 退勤情報を勤怠テーブルに更新
    public function updatePunchFinishForKintai($request, $over_time)
    {
        Kintai::where('kintai_id', $request->kintai_id)->update([
            'finish_time' => $request->finish_time,
            'finish_time_adj' => $request->finish_time_adj,
            'rest_time' => $request->rest_time,
            'no_rest_time' => $request->no_rest_time,
            'add_rest_time' => isset($request->add_rest_time) ? $request->add_rest_time : 0,
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
                'is_supported' => preg_match('/warm_/', $key),
            ]);
        }
        return;
    }

    public function getWorkableTimes($kintai)
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