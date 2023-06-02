<?php

namespace App\Services\Employee;

use App\Models\Employee;

class EmployeeRegisterService
{
    public function createEmployee($request)
    {
        // レコードを追加
        Employee::create([
            'employee_no' => $request->employee_no,
            'employee_name' => $request->employee_name,
            'base_id' => $request->base,
            'employee_category_id' => $request->employee_category,
            'monthly_workable_time_setting' => $request->monthly_workable_time_setting,
            'over_time_start_setting' => $request->over_time_start_setting,
        ]);
        return;
    }
}