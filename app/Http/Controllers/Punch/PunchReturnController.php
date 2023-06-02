<?php

namespace App\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\Punch\PunchReturnService;

class PunchReturnController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $PunchReturnService = new PunchReturnService;
        // 戻り打刻対象者を取得
        $employees = $PunchReturnService->getPunchReturnTargetEmployee();
        return view('punch_return.index')->with([
            'employees' => $employees,
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchReturnService = new PunchReturnService;
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 勤怠情報を取得
        $kintai = Kintai::getSpecify($request->punch_key)->first();
        // 勤怠テーブルに戻り情報を更新
        $PunchReturnService->updatePunchReturnForKintai($kintai->kintai_id, $nowDate, $kintai->out_time_adj);
        session()->flash('punch_type', '戻り');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '');
        return redirect()->route('punch.index');
    }
}
