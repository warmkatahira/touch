<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\PunchOutService;
use App\Services\KintaiCommonService;

class PunchOutController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $PunchOutService = new PunchOutService;
        // 外出打刻対象者を取得
        $employees = $PunchOutService->getPunchOutTargetEmployee();
        return view('punch_out.index')->with([
            'employees' => $employees,
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchOutService = new PunchOutService;
        $KintaiCommonService = new KintaiCommonService;
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 勤怠情報を取得
        $kintai = $KintaiCommonService->getKintai($request->punch_key);
        // 勤怠テーブルに外出情報を更新
        $PunchOutService->updatePunchOutForKintai($request->punch_key, $nowDate);
        session()->flash('punch_type', '外出');
        session()->flash('employee_name', $kintai['employee']['employee_name']);
        session()->flash('message', '');
        return redirect()->route('punch.index');
    }
}
