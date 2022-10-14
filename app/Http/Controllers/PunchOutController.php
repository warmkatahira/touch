<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\PunchOutService;

class PunchOutController extends Controller
{
    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->has('punch_out_targets')
                        ->orderBy('employee_no')
                        ->get();
        return view('punch_out.index')->with([
            'employees' => $employees,
        ]);
    }

    public function enter(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $PunchOutService = new PunchOutService;
        // リクエストパラメータを取得
        $req_param = $PunchOutService->getRequestParameter($request);
        // 更新する勤怠レコードを取得
        $kintai = $PunchOutService->getKintai($req_param['employee_no'], $nowDate->format('Y-m-d'));
        // 勤怠テーブルに外出情報を更新
        $PunchOutService->updatePunchOutForKintai($kintai['kintai_id'], $nowDate);
        session()->flash('punch_type', '外出');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '');
        return redirect()->route('punch.index');
    }
}
