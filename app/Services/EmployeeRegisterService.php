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
        // 拠点はロールによって可変
        // システム管理者 = 全て、その他 = ログインアカウントの拠点
        if(Auth::user()->role_id == 1){
            $bases = Base::all();
        }
        if(Auth::user()->role_id != 1){
            $bases = Base::where('base_id', Auth::user()->base_id)->get(); // firstだとエラーになるので、あえてgetにしている
        }
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
        ]);
        return;
    }
}