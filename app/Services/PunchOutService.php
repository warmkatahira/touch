<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\Employee;

class PunchOutService
{
    // 外出打刻対象者を取得
    public function getPunchOutTargetEmployee()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 当日の勤怠を取得
        $today_kintais = Kintai::where('work_day', $nowDate->format('Y-m-d'));
        // 自拠点の勤怠があって、退勤時間がNullかつ外出時間がNullの従業員
        $employees = Employee::joinSub($today_kintais, 'KINTAIS', function ($join) {
                $join->on('employees.employee_no', '=', 'KINTAIS.employee_no');
            })
            ->where('base_id', Auth::user()->base_id)
            ->whereNull('finish_time')
            ->whereNull('out_time')
            ->select('employees.employee_no', 'employees.employee_name', 'KINTAIS.kintai_id')
            ->orderBy('employee_no')
            ->get();
        return $employees;
    }

    // 勤怠テーブルに外出情報を更新
    public function updatePunchOutForKintai($kintai_id, $nowDate)
    {
        // 外出時間調整を取得
        $out_time_adj = $this->getOutTimeAdj($nowDate);
        // レコードを更新
        Kintai::where('kintai_id', $kintai_id)->update([
            'out_time' => $nowDate->format('H:i:00'),
            'out_time_adj' => $out_time_adj,
            'out_enabled' => 1,
        ]);
        return;
    }

    // 外出時間調整を算出・取得
    public function getOutTimeAdj($Date)
    {
        // 日時をインスタンス化
        $out_time_adj = new Carbon($Date);
        // 15分単位で切り捨て
        $out_time_adj = $out_time_adj->subMinutes($out_time_adj->minute % 15);
        $out_time_adj = $out_time_adj->format('H:i:00');
        return $out_time_adj;
    }
}