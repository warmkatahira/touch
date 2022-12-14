<?php

namespace App\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PunchManualService;
use App\Services\PunchFinishInputService;
use App\Services\PunchModifyService;
use App\Services\PunchFinishEnterService;
use App\Http\Requests\PunchManualRequest;

class PunchManualController extends Controller
{
    public function index()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // サービスクラスを定義
        $PunchManualService = new PunchManualService;
        // 自拠点の従業員を取得
        $employees = $PunchManualService->getEmployeeBase();
        return view('management_func.punch_manual.index')->with([
            'employees' => $employees,
        ]);
    }

    public function input(PunchManualRequest $request)
    {
        // サービスクラスを定義
        $PunchManualService = new PunchManualService;
        $PunchFinishInputService = new PunchFinishInputService;
        $PunchModifyService = new PunchModifyService;
        // 打刻可能な条件であるか確認
        $kintai = $PunchManualService->checkPunchAvailable($request);
        // 既に存在する勤怠であれば中断
        if(isset($kintai)){
            session()->flash('alert_danger', "打刻されている勤怠です。\n出勤日:".$request->work_day."\n従業員:".$kintai->employee->employee_name);
            return redirect()->back()->withInput();
        }
        // 外出戻り関連の時間を取得
        $out_return_time = $PunchModifyService->getOutReturnTime($request);
        // 出勤・退勤勤時間を取得
        $begin_finish_time = $PunchModifyService->getBeginFinishTime($request);
        // 出退勤時間から、取得可能な休憩時間を算出
        $rest_time = $PunchFinishInputService->getRestTimeForBeginFinish($begin_finish_time['begin_time_adj'], $begin_finish_time['finish_time_adj']);
        // 外出戻り時間から、取得可能な休憩時間を算出(外出戻り時間がある場合のみ)
        if(!is_null($out_return_time['out_return_time'])){
            $rest_time = $PunchFinishInputService->getRestTimeForOutReturn($rest_time, $out_return_time['out_time_adj'], $out_return_time['return_time_adj']);
        }
        // 休憩未取得回数の情報を取得
        $no_rest_times = $PunchFinishInputService->getNoRestTime($rest_time);
        // 稼働時間を算出
        $working_time = $PunchFinishInputService->getWorkingTime($begin_finish_time['begin_time_adj'], $begin_finish_time['finish_time_adj'], $rest_time, $out_return_time['out_return_time']);
        // 各種情報をセッションに格納
        $PunchModifyService->setSessionKintaiModifyInfo($out_return_time, $begin_finish_time, $rest_time, $no_rest_times, $working_time, $request->punch_begin_type);
        // 自拠点の荷主情報を取得
        $customer_info = $PunchFinishInputService->getCustomerInfo();
        // 荷主から応援タブの情報を取得
        $support_bases = $PunchFinishInputService->getSupportedBases();
        // 追加休憩取得時間を取得
        $add_rest_times = $PunchFinishInputService->getAddRestTime();
        // 追加休憩取得時間を表示させるか判定
        $add_rest_time_disp = $PunchFinishInputService->getAddRestTimeDisp();
        // 従業員情報を取得
        $employee = $PunchManualService->getEmployee($request->employee);
        return view('management_func.punch_manual.input')->with([
            'customers' => $customer_info['customers'],
            'customer_groups' => $customer_info['customer_groups'],
            'employee' => $employee,
            'work_day' => $request->work_day,
            'support_bases' => $support_bases,
            'add_rest_times' => $add_rest_times,
            'add_rest_time_disp' => $add_rest_time_disp,
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchModifyService = new PunchModifyService;
        $PunchFinishEnterService = new PunchFinishEnterService;
        $PunchManualService = new PunchManualService;
        // 概要を追加
        $kintai = $PunchManualService->addKintai($request);
        // 残業時間を算出
        $over_time = $PunchFinishEnterService->getOverTime($kintai, $request->working_time);
        // 残業時間を更新
        $PunchManualService->updateOverTime($kintai->kintai_id, $over_time);
        // 勤怠詳細を追加
        $PunchFinishEnterService->addPunchFinishForKintaiDetail($kintai->kintai_id, $request->working_time_input);
        // セッションをクリア
        $PunchModifyService->removeSessionKintaiModifyInfo();
        session()->flash('alert_success', $kintai->employee->employee_name.'さん【出勤日:'.$kintai->work_day.'】の手動打刻が完了しました。');
        return redirect()->route('punch.index');
    }
}
