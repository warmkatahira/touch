<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\PunchReturnService;
use App\Services\KintaiCommonService;

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
        $KintaiCommonService = new KintaiCommonService;
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 勤怠情報を取得
        $kintai = $KintaiCommonService->getKintai($request->punch_key);
        // 勤怠テーブルに戻り情報を更新
        $PunchReturnService->updatePunchReturnForKintai($kintai['kintai']['kintai_id'], $nowDate, $kintai['kintai']['out_time_adj']);
        session()->flash('punch_type', '戻り');
        session()->flash('employee_name', $kintai['employee']['employee_name']);
        session()->flash('message', '');
        return redirect()->route('punch.index');
    }
}
