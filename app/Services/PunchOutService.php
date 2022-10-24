<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;

class PunchOutService
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

    // 勤怠テーブルに外出情報を更新
    public function updatePunchOutForKintai($kintai_id, $nowDate)
    {
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