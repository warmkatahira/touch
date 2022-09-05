<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Kintai;

class PunchFinishService
{
    // 退勤時間調整を算出・取得する
    public function getFinishTimeAdj($nowDate)
    {
        $finish_time_adj = new Carbon($nowDate);
        $finish_time_adj = $finish_time_adj->subMinutes($finish_time_adj->minute % 15);
        $finish_time_adj = $finish_time_adj->format('H:i:00');
        return $finish_time_adj;
    }

    // 労働時間を算出
    public function getWorkingTime($employee_no, $nowDate, $finish_time_adj)
    {
        // 勤怠情報を取得
        $kintai = Kintai::where('employee_no', $employee_no)
                    ->where('work_day', $nowDate->format('Y-m-d'))
                    ->first();
        // 退勤時間調整を分数に変換
        $finish_time_adj_split = explode(":", $finish_time_adj);
        $finish_time_adj_minute = $finish_time_adj_split[0] * 60;
        $finish_time_adj_minute = $finish_time_adj_minute + $finish_time_adj_split[1];
        // 出勤時間調整を分数に変換
        $begin_time_adj_split = explode(":", $kintai->begin_time_adj);
        $begin_time_adj_minute = $begin_time_adj_split[0] * 60;
        $begin_time_adj_minute = $begin_time_adj_minute + $begin_time_adj_split[1];
        // 労働時間を算出(退勤時間調整 - 出勤時間調整)
        $working_time = $finish_time_adj_minute - $begin_time_adj_minute;
        return $working_time;
    }
}