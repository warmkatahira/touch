<?php

namespace App\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Services\PunchModifyService;
use App\Services\PunchFinishInputService;
use App\Services\PunchFinishEnterService;
use App\Services\KintaiCommonService;
use App\Http\Requests\PunchModifyRequest;

class PunchModifyController extends Controller
{
    public function index(Request $request)
    {
        // サービスクラスを定義
        $PunchModifyService = new PunchModifyService;
        $KintaiCommonService = new KintaiCommonService;
        // 勤怠IDをセッションに格納
        $PunchModifyService->setSessionKintaiId($request->kintai_id);
        // 勤怠情報を取得
        $kintai = $KintaiCommonService->getKintai(session('kintai_id'));
        return view('punch_modify.index')->with([
            'kintai' => $kintai['kintai'],
        ]);
    }

    // 出退勤・外出戻り時間をバリデーションしている
    public function input(PunchModifyRequest $request)
    {
        // サービスクラスを定義
        $PunchModifyService = new PunchModifyService;
        $PunchFinishInputService = new PunchFinishInputService;
        $KintaiCommonService = new KintaiCommonService;
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
        // 勤怠情報を取得
        $kintai = $KintaiCommonService->getKintai(session('kintai_id'));
        // 自拠点の荷主情報を取得
        $customer_info = $PunchFinishInputService->getCustomerInfo();
        return view('punch_modify.input')->with([
            'kintai' => $kintai['kintai'],
            'kintai_details' => $kintai['kintai_details'],
            'customers' => $customer_info['customers'],
            'customer_groups' => $customer_info['customer_groups'],
        ]);
    }

    public function enter(Request $request)
    {
        // サービスクラスを定義
        $PunchModifyService = new PunchModifyService;
        $PunchFinishEnterService = new PunchFinishEnterService;
        $KintaiCommonService = new KintaiCommonService;
        // 勤怠情報を取得
        $kintai = $KintaiCommonService->getKintai(session('kintai_id'));
        // 残業時間を算出
        $over_time = $PunchFinishEnterService->getOverTime($kintai['kintai'], $request->working_time);
        // 勤怠概要を更新
        $PunchModifyService->updatePunchModifyKintai($request, $over_time);
        // 荷主稼働時間を削除して追加
        $PunchModifyService->addPunchModifyForKintaiDetail($request->working_time_input);
        // セッションをクリア
        $PunchModifyService->removeSessionKintaiModifyInfo();
        session()->flash('alert_success', $kintai['kintai']->employee->employee_name.'さん【出勤日:'.$kintai['kintai']['work_day'].'】の修正が完了しました。');
        return redirect(session('back_url_1'));
    }
}
