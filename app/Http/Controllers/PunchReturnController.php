<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\PunchReturnService;

class PunchReturnController extends Controller
{
    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->has('punch_return_targets')->get();
        return view('punch_return.index')->with([
            'employees' => $employees,
        ]);
    }

    public function enter(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $PunchReturnService = new PunchReturnService;
        // リクエストパラメータを取得
        $req_param = $PunchReturnService->getRequestParameter($request);
        // 更新する勤怠レコードを取得
        $kintai = $PunchReturnService->getKintai($req_param['employee_no'], $nowDate->format('Y-m-d'));
        // 勤怠テーブルに戻り情報を更新
        $PunchReturnService->updatePunchReturnForKintai($kintai['kintai_id'], $nowDate, $kintai['out_time_adj']);
        session()->flash('punch_type', '戻り');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '');
        return redirect()->route('punch.index');
    }
}
