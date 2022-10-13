<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;

class PunchReturnService
{
    // リクエストパラメータを取得
    public function getRequestParameter($request)
    {
        // リクエストパラメータを必要な分だけ取得
        $req_param = $request->only([
            'employee_no',
        ]);
        return $req_param;
    }

    // 更新する勤怠レコードを取得
    public function getKintai($employee_no, $nowDate)
    {
        $kintai = Kintai::where('employee_no', $employee_no)
                        ->where('work_day', $nowDate)
                        ->first();
        return $kintai;
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
    public function getReturnTimeAdj($nowDate)
    {
        // 現在の日時をインスタンス化
        $return_time_adj = new Carbon($nowDate);
        // 15分単位で切り上げ
        $return_time_adj = $return_time_adj->addMinutes(15 - $return_time_adj->minute % 15);
        $return_time_adj = $return_time_adj->format('H:i:00');
        return $return_time_adj;
    }

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