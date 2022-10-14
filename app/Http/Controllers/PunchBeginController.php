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
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 現在の時刻が8時台より前であればon、9時台以降であればoff
        $punch_begin_type_enabled = $nowDate->hour <= 8 ? 'on' : 'off';
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->doesntHave('punch_begin_targets')->get();
        return view('punch_begin.index')->with([
            'employees' => $employees,
            'punch_begin_type_enabled' => $punch_begin_type_enabled,
        ]);
    }

    public function enter(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $PunchBeginService = new PunchBeginService;
        // リクエストパラメータを取得
        $req_param = $PunchBeginService->getRequestParameter($request);
        // 勤怠テーブルにレコードを追加
        $kintai = $PunchBeginService->addKintai($req_param, $nowDate);
        session()->flash('punch_type', '出勤');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '本日も宜しくお願いします');
        return redirect()->route('punch.index');
    }
}
