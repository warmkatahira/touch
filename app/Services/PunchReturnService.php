<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\Employee;

class PunchReturnService
{
    // 戻り打刻対象者を取得
    public function getPunchReturnTargetEmployee()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 当日の勤怠を取得
        $today_kintais = Kintai::where('work_day', $nowDate->format('Y-m-d'));
        // 自拠点の勤怠があって、外出時間がNot Nullかつ戻り時間がNullの従業員
        $employees = Employee::joinSub($today_kintais, 'KINTAIS', function ($join) {
                $join->on('employees.employee_no', '=', 'KINTAIS.employee_no');
            })
            ->where('base_id', Auth::user()->base_id)
            ->whereNotNull('out_time')
            ->whereNull('return_time')
            ->select('employees.employee_no', 'employees.employee_name', 'KINTAIS.kintai_id')
            ->orderBy('employee_no')
            ->get();
        return $employees;
    }

    // 勤怠テーブルに戻り情報を更新
    public function updatePunchReturnForKintai($kintai_id, $nowDate, $out_time_adj)
    {
        // 戻り時間調整を算出・取得
        $return_time_adj = $this->getReturnTimeAdj($nowDate);
        // 外出戻り時間を算出・取得
        $out_return_time = $this->getOutReturnTime($out_time_adj, $return_time_adj);
        // レコードを更新
        Kintai::where('kintai_id', $kintai_id)->update([
            'return_time' => $nowDate->format('H:i:00'),
            'return_time_adj' => $return_time_adj,
            'out_enabled' => null,
            'out_return_time' => $out_return_time,
        ]);
        return;
    }

    // 戻り時間調整を算出・取得
    public function getReturnTimeAdj($Date)
    {
        // 日時をインスタンス化
        $return_time_adj = new Carbon($Date);
        // 15分単位で切り上げ
        $return_time_adj = $return_time_adj->addMinutes(15 - $return_time_adj->minute % 15);
        $return_time_adj = $return_time_adj->format('H:i:00');
        return $return_time_adj;
    }

    // 外出戻り時間を算出・取得
    public function getOutReturnTime($out_time_adj, $return_time_adj)
    {
        // 外出時間調整を分数に変換
        $out_time_adj_split = explode(":", $out_time_adj);
        $out_time_adj_minute = $out_time_adj_split[0] * 60;
        $out_time_adj_minute = $out_time_adj_minute + $out_time_adj_split[1];
        // 戻り時間調整を分数に変換
        $return_time_adj_split = explode(":", $return_time_adj);
        $return_time_adj_minute = $return_time_adj_split[0] * 60;
        $return_time_adj_minute = $return_time_adj_minute + $return_time_adj_split[1];
        // 戻り時間調整 - 外出時間調整から外出戻り時間を算出
        $out_return_time = $return_time_adj_minute - $out_time_adj_minute;
        return $out_return_time;
    }
}