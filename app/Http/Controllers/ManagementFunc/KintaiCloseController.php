<?php

namespace App\Http\Controllers\ManagementFunc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KintaiCloseService;
use App\Services\CommonService;
use Carbon\Carbon;

class KintaiCloseController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $KintaiCloseService = new KintaiCloseService;
        // 未提出の勤怠情報を取得
        $not_close_kintais = $KintaiCloseService->getNotCloseKintai();
        return view('management_func.kintai_close.index')->with([
            'not_close_kintais' => $not_close_kintais,
        ]);
    }

    public function closing(Request $request)
    {
        // サービスクラスを定義
        $KintaiCloseService = new KintaiCloseService;
        $CommonService = new CommonService;
        // 指定された年月の勤怠提出情報を取得
        $kintai_close = $KintaiCloseService->checkKintaiClose($request->close_date);
        // 勤怠提出済みの年月であれば処理を中断
        if($kintai_close != 0){
            session()->flash('alert_danger', "提出済みの年月である為、提出できません。");
            return back();
        }
        // 月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($request->close_date);
        // 指定した月の全ての勤怠で管理者確認が実施されているか確認
        $not_close_kintais = $KintaiCloseService->checkManagerCheckComplete($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 管理者確認が未実施の勤怠があれば処理を中断
        if($not_close_kintais != 0){
            session()->flash('alert_danger', "管理者確認が未実施の勤怠がある為、提出できません。");
            return back();
        }
        // 勤怠提出テーブルを追加
        $KintaiCloseService->addKintaiClose($request->close_date);
        // 勤怠のロック処理を実施
        $KintaiCloseService->updateLockedAt($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        session()->flash('alert_success', Carbon::parse($request->close_date)->isoFormat('YYYY年MM月') . "の勤怠を提出しました。");
        return back();
    }
}
