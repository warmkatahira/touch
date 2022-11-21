<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeRegisterService
{
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