<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Kintai;

class PunchFinishService
{
    // 現状の勤怠情報を取得
    public function getKintai($employee_no, $nowDate)
    {
        // 勤怠情報を取得
        $kintai = Kintai::where('employee_no', $employee_no)
                    ->where('work_day', $nowDate->format('Y-m-d'))
                    ->first();
        return $kintai;
    }

    // 退勤時間調整を算出・取得する
    public function getFinishTimeAdj($nowDate)
    {
        $finish_time_adj = new Carbon($nowDate);
        $finish_time_adj = $finish_time_adj->subMinutes($finish_time_adj->minute % 15);
        $finish_time_adj = $finish_time_adj->format('H:i:00');
        return $finish_time_adj;
    }

    // 労働時間を算出
    public function getWorkingTime($kintai, $finish_time_adj)
    {
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

    // 取得可能な休憩時間を算出
    public function getRestTime($kintai, $finish_time_adj)
    {
        // 最大休憩取得時間をセット
        $rest_time = 90;
        // 出勤時間調整が10:45よりも遅ければ午前の休憩は取れないので、休憩時間から15分マイナスする
        if($kintai->begin_time_adj >= "10:45:00"){
            $rest_time -= 15;
        }
        // 退勤時間調整が10:30よりも早ければ午前の休憩は取れないので、休憩時間から15分マイナスする
        if($finish_time_adj <= "10:30:00"){
            $rest_time -= 15;
        }
        // 出勤時間調整が12:15よりも遅ければお昼の休憩は取れないので、休憩時間から60分マイナスする
        if($kintai->begin_time_adj >= "12:15:00"){
            $rest_time -= 60;
        }
        // 退勤時間調整が12:00よりも早ければお昼の休憩は取れないので、休憩時間から60分マイナスする
        if($finish_time_adj <= "12:00:00"){
            $rest_time -= 60;
        }
        // 出勤時間調整が15:15よりも遅ければ午後の休憩は取れないので、休憩時間から15分マイナスする
        if($kintai->begin_time_adj >= "15:15:00"){
            $rest_time -= 15;
        }
        // 退勤時間調整が15:00よりも早ければ午後の休憩は取れないので、休憩時間から15分マイナスする
        if($finish_time_adj <= "15:00:00"){
            $rest_time -= 15;
        }
        // 退勤時間調整がお昼休憩中なら、休憩時間を取らないように変更。
        if($finish_time_adj >= "12:15:00" && $finish_time_adj <= "12:45:00"){
            $rest_time -= 60;
        }
        return $rest_time;
    }

    // 休憩未取得回数の情報を取得
    public function getNoRestTime($rest_time)
    {
        // 変数をセット
        $no_rest_times = [];
        array_push($no_rest_times, ['minute' => 0, 'text1' => 'なし']);
        // 休憩時間に合わせて選択肢を変動
        if($rest_time == 15){
            array_push($no_rest_times, ['minute' => 15, 'text1' => '15分1回']);
        }
        if($rest_time == 30){
            array_push($no_rest_times, ['minute' => 15, 'text1' => '15分1回']);
            array_push($no_rest_times, ['minute' => 30, 'text1' => '15分2回']);
        }
        if($rest_time == 60){
            array_push($no_rest_times, ['minute' => 60, 'text1' => '60分1回']);
        }
        if($rest_time == 75){
            array_push($no_rest_times, ['minute' => 15, 'text1' => '15分1回']);
            array_push($no_rest_times, ['minute' => 60, 'text1' => '60分1回']);
            array_push($no_rest_times, ['minute' => 75, 'text1' => '15分1回+60分1回']);
        }
        if($rest_time == 90){
            array_push($no_rest_times, ['minute' => 15, 'text1' => '15分1回']);
            array_push($no_rest_times, ['minute' => 30, 'text1' => '15分2回']);
            array_push($no_rest_times, ['minute' => 60, 'text1' => '60分1回']);
            array_push($no_rest_times, ['minute' => 75, 'text1' => '15分1回+60分1回']);
            array_push($no_rest_times, ['minute' => 90, 'text1' => '15分2回+60分1回']);
        }
        return $no_rest_times;        
    }
}