<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Base;
use App\Models\EmployeeCategory;

class EmployeeRegisterService
{
    public function getPulldownInfo()
    {
        // 拠点を取得
        $bases = Base::all();
        // 従業員区分を取得
        $employee_categories = EmployeeCategory::all();
        return compact('bases', 'employee_categories');
    }

    public function addEmployee($request)
    {
        // レコードを追加
        Employee::create([
            'employee_no' => $request->employee_no,
            'employee_name' => $request->employee_name,
            'base_id' => $request->base,
            'employee_category_id' => $request->employee_category,
            'monthly_workable_time_setting' => $request->monthly_workable_time_setting,
        ]);
        return;
    }
}