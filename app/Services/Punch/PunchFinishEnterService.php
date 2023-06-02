<?php

namespace App\Services\Punch;

use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Models\Kintai;
use App\Models\Base;
use App\Models\KintaiDetail;
use App\Models\Holiday;
use App\Models\Employee;

class PunchFinishEnterService
{
    // 残業時間を算出・取得
    public function getOverTime($kintai, $working_time)
    {
        // この稼働時間を超えたら残業時間が付き始めるという値を取得
        $over_time_start = $this->getOverTimeStart($kintai->employee->employee_category->employee_category_id, $kintai->employee->over_time_start_setting);
        // 初期値として0を設定
        $over_time = 0;
        // 稼働時間が残業開始時間を超えていたら残業発生
        if($working_time > $over_time_start){
            $over_time = $working_time - $over_time_start;
        }
        return $over_time;
    }

    // この稼働時間を超えたら残業時間が付き始めるという値を取得
    public function getOverTimeStart($employee_category_id, $over_time_start_setting)
    {
        // 残業開始時間設定が0.25以上であれば、設定を優先する
        if($over_time_start_setting >= 0.25){
            $over_time_start = $over_time_start_setting;
        }
        if($over_time_start_setting < 0.25){
            // 社員の場合
            if($employee_category_id == 1){
                $over_time_start = 7.5;
            }
            // パートの場合
            if($employee_category_id == 2){
                $over_time_start = 8.0;
            }
        }
        return $over_time_start;
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
                'is_supported' => Base::getSpecify($key)->count(), // IDにbasesに含まれていたら応援なので、1をセット（カウントで自動で1か0が入る）
            ]);
        }
        return;
    }

    public function getWorkableTimes($kintai)
    {
        // 月間稼働可能時間設定を取得
        $employee = Employee::getSpecify($kintai->employee_no)->first();
        $monthly_workable_time_setting = $employee->monthly_workable_time_setting;
        // 月初の日付を取得
        $start_day = CarbonImmutable::now()->startOfMonth()->toDateString();
        // 月末の日付を取得
        $end_day = CarbonImmutable::now()->endOfMonth()->toDateString();
        // 当月の稼働時間を算出(0.25単位に変換している)
        $total_month_working_time = (Kintai::where('employee_no', $kintai->employee_no)
                                    ->whereBetween('work_day', [$start_day, $end_day])
                                    ->sum('working_time')) / 60;
        // 定総労働時間 - 当月の稼働時間で労働可能時間を算出
        $workable_times = $monthly_workable_time_setting - $total_month_working_time;
        return compact('monthly_workable_time_setting', 'workable_times', 'total_month_working_time');
    }
}