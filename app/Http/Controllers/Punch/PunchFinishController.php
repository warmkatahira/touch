<?php

namespace App\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kintai;
use App\Services\Punch\PunchFinishInputService;
use App\Services\Punch\PunchFinishEnterService;

class PunchFinishController extends Controller
{
    public function index()
    {
        // インスタンス化
        $PunchFinishInputService = new PunchFinishInputService;
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 退勤打刻対象者を取得
        $employees = $PunchFinishInputService->getPunchFinishTargetEmployee($nowDate);
        return view('punch_finish.index')->with([
            'employees' => $employees,
        ]);
    }

    public function input(Request $request)
    {
        // インスタンス化
        $PunchFinishInputService = new PunchFinishInputService;
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 退勤時間をフォーマット
        $finish_time = $PunchFinishInputService->formatFinishTime($nowDate);
        // 勤怠情報を取得
        $kintai = Kintai::getSpecify($request->punch_key)->first();
        // 退勤時間調整を算出
        $finish_time_adj = $PunchFinishInputService->getFinishTimeAdj($nowDate);
        // 出退勤時間から、取得可能な休憩時間を算出
        $rest_time = $PunchFinishInputService->getRestTimeForBeginFinish($kintai->begin_time_adj, $finish_time_adj);
        // 外出戻り時間から、取得可能な休憩時間を算出(外出戻り時間がある場合のみ)
        if($kintai->out_return_time != 0){
            $rest_time = $PunchFinishInputService->getRestTimeForOutReturn($rest_time, $kintai->out_time_adj, $kintai->return_time_adj);
        }
        // 休憩未取得回数の情報を取得
        $no_rest_times = $PunchFinishInputService->getNoRestTime($kintai->employee_no, $rest_time);
        // 稼働時間を算出
        $working_time = $PunchFinishInputService->getWorkingTime($kintai->begin_time_adj, $finish_time_adj, $rest_time, $kintai->out_return_time);
        // 自拠点の荷主情報を取得
        $customer_info = $PunchFinishInputService->getCustomerInfo();
        // 荷主から応援タブの情報を取得
        $support_bases = $PunchFinishInputService->getSupportedBases();
        // 追加休憩取得時間を取得
        $add_rest_times = $PunchFinishInputService->getAddRestTime();
        // 追加休憩取得時間を表示させるか判定
        $add_rest_time_disp = $PunchFinishInputService->getAddRestTimeDisp();
        return view('punch_finish.input')->with([
            'kintai' => $kintai,
            'finish_time' => $finish_time,
            'finish_time_adj' => $finish_time_adj,
            'working_time' => $working_time,
            'rest_time' => $rest_time,
            'no_rest_times' => $no_rest_times,
            'customers' => $customer_info['customers'],
            'customer_groups' => $customer_info['customer_groups'],
            'support_bases' => $support_bases,
            'add_rest_times' => $add_rest_times,
            'add_rest_time_disp' => $add_rest_time_disp,
        ]);
    }

    public function enter(Request $request)
    {
        // インスタンス化
        $PunchFinishEnterService = new PunchFinishEnterService;
        // 勤怠情報を取得
        $kintai = Kintai::getSpecify($request->kintai_id)->first();
        // 残業時間を算出
        $over_time = $PunchFinishEnterService->getOverTime($kintai, $request->working_time);
        // 勤怠概要を更新
        $PunchFinishEnterService->updatePunchFinishForKintai($request, $over_time);
        // 勤怠詳細を追加
        $PunchFinishEnterService->addPunchFinishForKintaiDetail($request->kintai_id, $request->working_time_input);
        // 労働可能時間を算出
        $hours_data = $PunchFinishEnterService->getWorkableTimes($kintai);
        session()->flash('punch_type', '退勤');
        session()->flash('employee_name', $kintai->employee->employee_name);
        session()->flash('message', '1日お疲れ様でした');
        session()->flash('monthly_workable_time_setting', $hours_data['monthly_workable_time_setting']);
        session()->flash('workable_times', $hours_data['monthly_workable_time_setting'] == 0 ? 0 : $hours_data['workable_times']);
        session()->flash('total_month_working_time', $hours_data['total_month_working_time']);
        // 残業が発生していればメッセージを表示させる
        if($over_time != 0){
            session()->flash('over_time', $over_time);
        }
        return redirect()->route('punch_finish.index');
    }
}
