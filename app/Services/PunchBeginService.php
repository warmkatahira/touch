<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Employee;
use App\Models\Kintai;
use App\Models\KintaiDetail;

class PunchBeginService
{
    // リクエストパラメータを取得
    public function getRequestParameter($request)
    {
        // リクエストパラメータを必要な分だけ取得
        $req_param = $request->only([
            'employee_no',
            'punch_begin_type',
        ]);
        return $req_param;
    }

    // 勤怠テーブルに追加
    public function addKintai($req_param, $nowDate)
    {
        // 早出フラグを取得(リクエストパラメータがある = 早出となる) ※早出は1
        $early_work_enabled = isset($req_param['punch_begin_type']) ? 1 : 0;
        // 出勤時間調整を算出・取得
        $begin_time_adj = $this->getBeginTimeAdj($nowDate, $early_work_enabled);
        // レコードを追加
        $kintai = Kintai::create([
            'kintai_id' => $req_param['employee_no'].'-'.$nowDate->format('Ymd'),
            'employee_no' => $req_param['employee_no'],
            'work_day' => $nowDate->format('Ymd'),
            'begin_time' => $nowDate->format('H:i:00'), // 秒は00に調整している
            'begin_time_adj' => $begin_time_adj,
            'out_return_time' => 0,
            'early_work_enabled' => $early_work_enabled,
        ]);
        return $kintai;
    }

    // 出勤時間調整を算出・取得
    public function getBeginTimeAdj($nowDate, $early_work_enabled)
    {
        // 現在の日時をインスタンス化
        $begin_time_adj = new Carbon($nowDate);
        // 9時前かつ早出ではない(0)場合、09:00:00に調整する
        if($begin_time_adj->format('H:i:00') <= "09:00:00" && $early_work_enabled == 0){
            $begin_time_adj = "09:00:00";
        }else{
            // 15分単位で切り上げ
            $begin_time_adj = $begin_time_adj->addMinutes(15 - $begin_time_adj->minute % 15);
            $begin_time_adj = $begin_time_adj->format('H:i:00');
        }
        return $begin_time_adj;
    }
}