<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\EmployeeListService;
use App\Services\EmployeeRegisterService;
use App\Services\KintaiReportExportService;
use App\Services\CommonService;

class EmployeeListController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $CommonService = new CommonService;
        // セッションを削除
        $EmployeeListService->deleteSearchSession();
        // 初期条件をセット
        $EmployeeListService->setDefaultCondition();
        // 従業員を取得
        $employees = $EmployeeListService->getEmployeeSearch();
        // 拠点情報を取得
        $bases = $CommonService->getBases(true, false);
        // 従業員区分を取得
        $employee_categories = $CommonService->getEmployeeCategories();
        return view('employee_list.index')->with([
            'employees' => $employees,
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $CommonService = new CommonService;
        // セッションを削除
        $EmployeeListService->deleteSearchSession();
        // 検索条件をセット
        $EmployeeListService->getSearchCondition($request);
        // 従業員を取得
        $employees = $EmployeeListService->getEmployeeSearch();
        // 拠点情報を取得
        $bases = $CommonService->getBases(true, false);
        // 従業員区分を取得
        $employee_categories = $CommonService->getEmployeeCategories();
        return view('employee_list.index')->with([
            'employees' => $employees,
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function detail(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $KintaiReportExportService = new KintaiReportExportService;
        $CommonService = new CommonService;
        // 月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth(Carbon::now());
        // 従業員の情報を取得
        $employee = $CommonService->getEmployee($request->employee_no);
        // 当月稼働情報を取得
        $this_month_data = $EmployeeListService->getThisMonthData($request->employee_no);
        // 荷主稼働時間トップ5の情報を取得
        $customer_working_time = $EmployeeListService->getCustomerWorkingTime($request->employee_no);
        // 当月の情報を取得
        $month_date = $KintaiReportExportService->getMonthDate($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 勤怠表に使用する情報を取得
        $kintais = $KintaiReportExportService->getExportKintaiNormal($month_date['month_date'], $employee['employees'], $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
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
        $CommonService = new CommonService;
        // 従業員の情報を取得
        $employee = $CommonService->getEmployee($request->employee_no);
        // 拠点情報を取得
        $bases = $CommonService->getBases(false);
        // 従業員区分を取得
        $employee_categories = $CommonService->getEmployeeCategories();
        return view('employee_list.modify')->with([
            'employee' => $employee['employee'],
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }
}
