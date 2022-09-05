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
        ]);
        return $req_param;
    }

    // 勤怠テーブルに追加
    public function addKintai($req_param, $nowDate)
    {
        $begin_time_adj = $this->getBeginTimeAdj($nowDate);
        // レコードを追加
        Kintai::create([
            'employee_no' => $req_param['employee_no'],
            'work_day' => $nowDate->format('Ymd'),
            'begin_time' => $nowDate->format('H:i:00'), // 秒は00に調整している
            'begin_time_adj' => $begin_time_adj,
            'created_at' => $nowDate,
            'updated_at' => $nowDate,
        ]);
        return;
    }

    // 出勤時間調整を算出・取得する
    public function getBeginTimeAdj($nowDate)
    {
        $begin_time_adj = new Carbon($nowDate);
        // 9時前であれば、09:00:00に調整する
        if($begin_time_adj->format('H:i:00') <= "09:00:00"){
            $begin_time_adj = "09:00:00";
        }else{
            $begin_time_adj = $begin_time_adj->addMinutes(15 - $begin_time_adj->minute % 15);
            $begin_time_adj = $begin_time_adj->format('H:i:00');
        }
        return $begin_time_adj;
    }

    // 打刻者の情報を取得
    public function getEmployeeInfo($req_param)
    {
        $employee = Employee::where('employee_no', $req_param['employee_no'])->first();
        return $employee;
    }
}