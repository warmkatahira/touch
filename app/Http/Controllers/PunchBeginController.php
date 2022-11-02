<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\PunchBeginService;

class PunchBeginController extends Controller
{

    public function index()
    {
        // サービスクラスを定義
        $PunchBeginService = new PunchBeginService;
        // 出勤タイプを変更するボタンの表示を管理
        $punch_begin_type_btn_disp = $PunchBeginService->getBeginTypeBtnDisp();
        // 出勤打刻対象者を取得
        $employees = $PunchBeginService->getPunchBeginTargetEmployee();
        return view('punch_begin.index')->with([
            'employees' => $employees,
            'punch_begin_type_btn_disp' => $punch_begin_type_btn_disp,
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchBeginService = new PunchBeginService;
        // 勤怠テーブルにレコードを追加
        $kintai = $PunchBeginService->addKintai($request);
        session()->flash('punch_type', '出勤');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '本日も宜しくお願いします');
        return redirect()->route('punch.index');
    }
}
