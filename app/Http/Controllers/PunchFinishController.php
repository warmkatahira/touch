<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Employee;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Kintai;
use App\Services\PunchFinishInputService;
use App\Services\PunchFinishEnterService;

class PunchFinishController extends Controller
{
    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->has('punch_finish_targets')
                        ->orderBy('employee_no')
                        ->get();
        return view('punch_finish.index')->with([
            'employees' => $employees,
        ]);
    }

    public function input(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 退勤時間
        $finish_time = $nowDate->format('H:i:00');
        // サービスクラスを定義
        $PunchFinishInputService = new PunchFinishInputService;
        // 勤怠情報を取得
        $kintai = $PunchFinishInputService->getKintai($request->employee_no, $nowDate);
        // 退勤時間調整を算出
        $finish_time_adj = $PunchFinishInputService->getFinishTimeAdj($nowDate);
        // 出退勤時間から、取得可能な休憩時間を算出
        $rest_time = $PunchFinishInputService->getRestTimeForBeginFinish($kintai->begin_time_adj, $finish_time_adj);
        // 外出戻り時間から、取得可能な休憩時間を算出(外出戻り時間がある場合のみ)
        if($kintai->out_return_time != 0){
            $rest_time = $PunchFinishInputService->getRestTimeForOutReturn($rest_time, $kintai->out_time_adj, $kintai->return_time_adj);
        }
        // 休憩未取得回数の情報を取得
        $no_rest_times = $PunchFinishInputService->getNoRestTime($rest_time);
        // 稼働時間を算出
        $working_time = $PunchFinishInputService->getWorkingTime($kintai->begin_time_adj, $finish_time_adj, $rest_time, $kintai->out_return_time);
        // 自拠点の荷主情報を取得
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $customer_groups = CustomerGroup::all();
        return view('punch_finish.input')->with([
            'kintai' => $kintai,
            'finish_time' => $finish_time,
            'finish_time_adj' => $finish_time_adj,
            'working_time' => $working_time,
            'rest_time' => $rest_time,
            'no_rest_times' => $no_rest_times,
            'customers' => $customers,
            'customer_groups' => $customer_groups,
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchFinishEnterService = new PunchFinishEnterService;
        // 勤怠情報を取得
        $kintai = $PunchFinishEnterService->getKintai($request->kintai_id);
        // 残業時間を算出
        $over_time = $PunchFinishEnterService->getOverTime($kintai, $request->working_time);
        // 勤怠概要を更新
        $PunchFinishEnterService->updatePunchFinishForKintai($request, $over_time);
        // 勤怠詳細を追加
        $PunchFinishEnterService->addPunchFinishForKintaiDetail($request->kintai_id, $request->working_time_input);
        session()->flash('punch_type', '退勤');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '1日お疲れ様でした');
        return redirect()->route('punch.index');
    }
}
