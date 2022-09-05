<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Employee;
use App\Models\Customer;
use App\Models\Kintai;

use App\Services\PunchBeginService;

class PunchBeginController extends Controller
{

    public function menu()
    {
        return view('punch.menu');
    }

    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->doesntHave('punch_begin_targets')->get();
        // 自拠点の荷主情報を取得
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        return view('punch.begin')->with([
            'employees' => $employees,
            'customers' => $customers,
        ]);
    }

    public function confirm(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $PunchBeginService = new PunchBeginService;
        // リクエストパラメータを取得
        $req_param = $PunchBeginService->getRequestParameter($request);
        // 勤怠テーブルにレコードを追加
        $kintai_id = $PunchBeginService->addKintai($req_param, $nowDate);
        // 打刻者の情報を取得
        $employee = $PunchBeginService->getEmployeeInfo($req_param);
        session()->flash('alert_punch', "出勤打刻が完了しました\n\n" . $employee['employee_name'] . ' さん');
        return redirect()->route('punch.menu');
    }
}
