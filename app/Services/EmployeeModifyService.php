<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeModifyService
{
    public function modifyEmployee($request)
    {
        // レコードを追加
        Employee::where('employee_no', $request->employee_no)->update([
            'employee_name' => $request->employee_name,
            'base_id' => $request->base,
            'employee_category_id' => $request->employee_category,
            'monthly_workable_time_setting' => $request->monthly_workable_time_setting,
        ]);
        return;
    }
}