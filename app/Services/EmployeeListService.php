<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Base;
use App\Models\EmployeeCategory;

class EmployeeListService
{
    public function deleteSearchSession()
    {
        // セッションを削除
        session()->forget(['search_base', 'search_employee_category', 'search_employee_name']);
        return;
    }

    public function setDefaultCondition()
    {
        // 初期条件をセット
        session(['search_base' => Auth::user()->base_id]);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['search_base' => $request->search_base]);
        session(['search_employee_category' => $request->search_employee_category]);
        session(['search_employee_name' => $request->search_employee_name]);
        return;
    }

    public function getEmployeeSearch()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // クエリをセット
        $query = Employee::query();
        // 氏名条件がある場合
        if (!empty(session('search_employee_name'))) {
            $query->where('employee_name', 'LIKE', '%'.session('search_employee_name').'%');
        }
        // 営業所条件がある場合
        if (!empty(session('search_base'))) {
            $query->where('base_id', session('search_base'));
        }
        // 区分条件がある場合
        if (!empty(session('search_employee_category'))) {
            $query->where('employee_category_id', session('search_employee_category'));
        }
        $employees = $query->orderBy('employee_no')->get();
        return $employees;
    }

    public function getPulldownInfo()
    {
        // 拠点と従業員区分を取得
        $bases = Base::all();
        $employee_categories = EmployeeCategory::all();
        return compact('bases', 'employee_categories');
    }

    public function getEmployee($employee_no)
    {
        // 選択された従業員の情報を取得
        $employee = Employee::where('employee_no', $employee_no)->first();
        return $employee;
    }
}