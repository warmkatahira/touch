<?php

namespace App\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Punch\PunchBeginService;

class PunchBeginController extends Controller
{

    public function index()
    {
        // インスタンス化
        $PunchBeginService = new PunchBeginService;
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 出勤タイプを変更するボタンの表示を管理
        $punch_begin_type_btn_disp = $PunchBeginService->getBeginTypeBtnDisp($nowDate);
        // 早出ができる状態の時、直近4時間分の情報を取得（15分刻みで）
        $early_work_select_info = $PunchBeginService->getEarlyWorkSelectInfo($nowDate, $punch_begin_type_btn_disp);
        // 出勤打刻対象者を取得
        $employees = $PunchBeginService->getPunchBeginTargetEmployee();
        return view('punch_begin.index')->with([
            'employees' => $employees,
            'punch_begin_type_btn_disp' => $punch_begin_type_btn_disp,
            'early_work_select_info' => $early_work_select_info,
        ]);
    }

    public function enter(Request $request)
    {
        // インスタンス化
        $PunchBeginService = new PunchBeginService;
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 勤怠テーブルにレコードを追加
        $kintai = $PunchBeginService->createKintai($request);
        session()->flash('punch_type', '出勤');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '本日も宜しくお願いします');
        return redirect()->back();
    }
}
