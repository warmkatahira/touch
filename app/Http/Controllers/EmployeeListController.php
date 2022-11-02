<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeListService;
use App\Services\EmployeeRegisterService;

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
        // サービスクラスを定義
        $EmployeeListService = new EmployeeListService;
        $EmployeeRegisterService = new EmployeeRegisterService;
        // 選択された従業員の情報を取得
        $employee = $EmployeeListService->getEmployee($request->employee_no);
        // プルダウン情報を取得
        $pulldown_info = $EmployeeRegisterService->getPulldownInfo();
        return view('employee_list.detail')->with([
            'employee' => $employee,
            'bases' => $pulldown_info['bases'],
            'employee_categories' => $pulldown_info['employee_categories'],
        ]);
    }
}
