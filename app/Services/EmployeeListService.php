<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Base;
use App\Models\EmployeeCategory;
use App\Models\Kintai;
use App\Models\KintaiDetail;

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
        // 自拠点従業員の当月の残業時間を集計
        $this_month_over_time = Kintai::join('employees', 'employees.employee_no', 'kintais.employee_no')
                                    ->where('base_id', session('search_base'))
                                    ->whereBetween('work_day', ['2022-11-01' , '2022-11-30'])
                                    ->select(DB::raw("sum(over_time) as total_over_time, kintais.employee_no"))
                                    ->groupBy('employee_no');
        // 集計した勤怠を従業員テーブルと結合
        $employees = Employee::
            leftJoinSub($this_month_over_time, 'OVERTIME', function ($join) {
                $join->on('employees.employee_no', '=', 'OVERTIME.employee_no');
            })
            ->where('employees.base_id', session('search_base'))
            ->select('employees.*', 'OVERTIME.total_over_time');
        // 氏名条件がある場合
        if (!empty(session('search_employee_name'))) {
            $employees->where('employee_name', 'LIKE', '%'.session('search_employee_name').'%');
        }
        // 区分条件がある場合
        if (!empty(session('search_employee_category'))) {
            $employees->where('employee_category_id', session('search_employee_category'));
        }
        $employees = $employees->orderBy('employees.employee_no')->get();
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
        // 選択された従業員の情報を取得(getは勤怠表用)
        $employee = Employee::where('employee_no', $employee_no)->first();
        $employees = Employee::where('employee_no', $employee_no)->get();
        return compact('employee', 'employees');
    }

    public function getThisMonthData($employee_no){
        // 当月の合計時間・稼働日数を取得
        $total_data = Kintai::where('employee_no', $employee_no)
                        ->whereBetween('work_day', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
                        ->select(DB::raw("sum(working_time) as total_working_time, sum(over_time) as total_over_time, count(work_day) as working_days, DATE_FORMAT(work_day, '%Y-%m') as date"))
                        ->groupBy('employee_no', 'date')
                        ->first();
        return compact('total_data');
    }

    public function getCustomerWorkingTime($employee_no)
    {
        // 対象従業員の当月の勤怠を取得
        $kintais = Kintai::where('employee_no', $employee_no)
                    ->whereBetween('work_day', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()]);
        // 取得した勤怠を勤怠詳細テーブルと結合して、荷主毎の稼働時間を集計
        $customer_working_time = KintaiDetail::
            joinSub($kintais, 'KINTAIS', function ($join) {
                $join->on('kintai_details.kintai_id', '=', 'KINTAIS.kintai_id');
            })
            ->join('customers', 'customers.customer_id', 'kintai_details.customer_id')
            ->select(DB::raw("sum(customer_working_time) as total_customer_working_time, DATE_FORMAT(work_day, '%Y-%m') as date, kintai_details.customer_id, customer_name"))
            ->groupBy('date', 'customer_id')
            ->orderBy('total_customer_working_time', 'desc')
            ->take(5)
            ->get();
        return $customer_working_time;
    }
}