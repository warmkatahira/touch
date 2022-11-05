<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\EmployeeListService;
use App\Services\EmployeeRegisterService;
use App\Services\KintaiReportOutputService;

class EmployeeListController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        // セッションを削除
        $EmployeeListService->deleteSearchSession();
        // 初期条件をセット
        $EmployeeListService->setDefaultCondition();
        // 従業員を取得
        $employees = $EmployeeListService->getEmployeeSearch();
        // プルダウンの情報を取得
        $pulldown_info = $EmployeeListService->getPulldownInfo();
        return view('employee_list.index')->with([
            'employees' => $employees,
            'bases' => $pulldown_info['bases'],
            'employee_categories' => $pulldown_info['employee_categories'],
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        // セッションを削除
        $EmployeeListService->deleteSearchSession();
        // 検索条件をセット
        $EmployeeListService->getSearchCondition($request);
        // 従業員を取得
        $employees = $EmployeeListService->getEmployeeSearch();
        // プルダウン情報を取得
        $pulldown_info = $EmployeeListService->getPulldownInfo();
        return view('employee_list.index')->with([
            'employees' => $employees,
            'bases' => $pulldown_info['bases'],
            'employee_categories' => $pulldown_info['employee_categories'],
        ]);
    }

    public function detail(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $KintaiReportOutputService = new KintaiReportOutputService;
        // 従業員の情報を取得
        $employee = $EmployeeListService->getEmployee($request->employee_no);
        // 当月稼働情報を取得
        $this_month_data = $EmployeeListService->getThisMonthData($request->employee_no);
        // 荷主稼働時間トップ5の情報を取得
        $customer_working_time = $EmployeeListService->getCustomerWorkingTime($request->employee_no);
        // 当月の情報を取得
        $month_date = $KintaiReportOutputService->getMonthDate(Carbon::now());
        // 勤怠表に使用する情報を取得
        $kintais = $KintaiReportOutputService->getOutputKintaiNormal($month_date['month_date'], $employee['employees'], $month_date['start_day'], $month_date['end_day']);
        return view('employee_list.detail')->with([
            'employee' => $employee['employee'],
            'working_days' => is_null($this_month_data['total_data']) ? 0 : $this_month_data['total_data']['working_days'],
            'total_working_time' => is_null($this_month_data['total_data']) ? 0 : $this_month_data['total_data']['total_working_time'],
            'total_over_time' => is_null($this_month_data['total_data']) ? 0 : $this_month_data['total_data']['total_over_time'],
            'customer_working_time' => $customer_working_time,
            'month_date' => $month_date,
            'kintais' => $kintais,
        ]);
    }

    public function modify(Request $request)
    {
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $EmployeeRegisterService = new EmployeeRegisterService;
        // 従業員の情報を取得
        $employee = $EmployeeListService->getEmployee($request->employee_no);
        // プルダウン情報を取得
        $pulldown_info = $EmployeeRegisterService->getPulldownInfo();
        return view('employee_list.modify')->with([
            'employee' => $employee['employee'],
            'bases' => $pulldown_info['bases'],
            'employee_categories' => $pulldown_info['employee_categories'],
        ]);
    }
}
