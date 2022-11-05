<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Services\EmployeeRegisterService;
use App\Services\EmployeeModifyService;

class EmployeeController extends Controller
{
    public function register_index()
    {
        // サービスクラスを定義
        $EmployeeRegisterService = new EmployeeRegisterService;
        // プルダウンの情報を取得
        $pulldown_info = $EmployeeRegisterService->getPulldownInfo();
        return view('employee_register.index')->with([
            'bases' => $pulldown_info['bases'],
            'employee_categories' => $pulldown_info['employee_categories'],
        ]);
    }

    public function register(EmployeeRequest $request)
    {
        // サービスクラスを定義
        $EmployeeRegisterService = new EmployeeRegisterService;
        // レコードを追加
        $EmployeeRegisterService->addEmployee($request);
        session()->flash('alert_success', $request->employee_name.'さんを追加しました。');
        return redirect(session('back_url_1'));
    }

    public function modify(EmployeeRequest $request)
    {
        // サービスクラスを定義
        $EmployeeModifyService = new EmployeeModifyService;
        // レコードを変更
        $EmployeeModifyService->modifyEmployee($request);
        session()->flash('alert_success', $request->employee_name.'さんの情報を更新しました。');
        return redirect(session('back_url_1'));
    }
}
