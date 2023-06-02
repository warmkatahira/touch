<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Services\Employee\EmployeeRegisterService;
use App\Services\Employee\EmployeeModifyService;
use App\Services\CommonService;
use App\Models\EmployeeCategory;

class EmployeeController extends Controller
{
    public function register_index()
    {
        // サービスクラスを定義
        $EmployeeRegisterService = new EmployeeRegisterService;
        $CommonService = new CommonService;
        // 拠点情報を取得
        $bases = $CommonService->getBases(false, false);
        // 従業員区分を取得
        $employee_categories = EmployeeCategory::getAll()->get();
        return view('employee_register.index')->with([
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function register(EmployeeRequest $request)
    {
        // サービスクラスを定義
        $EmployeeRegisterService = new EmployeeRegisterService;
        // レコードを追加
        $EmployeeRegisterService->createEmployee($request);
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
