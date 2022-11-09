<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Base;
use App\Models\Role;
use App\Models\Employee;

class CommonService
{
    // basesテーブルの情報+パラメータによって「全社」も取得する
    public function getBases($zensha_enabled)
    {
        // 拠点情報を取得
        $bases = Base::all();
        // 配列をセット
        $base_info = [];
        // zensha_enabledがtrueなら全社をセット
        if($zensha_enabled == true){
            $base_info[0] = '全社';
        }
        // baseテーブルのレコードをセット
        foreach($bases as $base){
            $base_info[$base->base_id] = $base->base_name;
        }
        return $base_info;
    }

    // 指定された従業員番号の情報を取得
    public function getEmployee($employee_no)
    {
        // 選択された従業員の情報を取得
        $employee = Employee::where('employee_no', $employee_no)->first();
        $employees = Employee::where('employee_no', $employee_no)->get();
        return compact('employee', 'employees');
    }

    // パラメータの月初・月末の日付を取得
    public function getStartEndOfMonth($date)
    {
        // パラメータをインスタンス化
        $start = new Carbon($date);
        $end = new Carbon($date);
        // 月初と月末の日付を取得
        $start_of_month = $start->startOfMonth()->toDateString();
        $end_of_month = $end->endOfMonth()->toDateString();
        return compact('start_of_month', 'end_of_month');
    }
}