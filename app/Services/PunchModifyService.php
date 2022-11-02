<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Services\PunchOutService;
use App\Services\PunchReturnService;
use App\Services\PunchBeginService;
use App\Services\PunchFinishInputService;

class PunchModifyService
{
    public function setSessionKintaiId($kintai_id)
    {
        // 勤怠IDをセッションに格納
        session(['kintai_id' => $kintai_id]);
        return;
    }

    public function getOutReturnTime($request)
    {
        // 初期値をセット
        $out_time_adj = null;
        $return_time_adj = null;
        $out_return_time = 0;
        if(isset($request->out_time)){
            // サービスクラスを定義
            $PunchOutService = new PunchOutService;
            $PunchReturnService = new PunchReturnService;
            // 外出時間調整を取得
            $out_time_adj = $PunchOutService->getOutTimeAdj($request->out_time);
            // 戻り時間調整を取得
            $return_time_adj = $PunchReturnService->getReturnTimeAdj($request->return_time);
            // 外出戻り時間を算出・取得
            $out_return_time = $PunchReturnService->getOutReturnTime($out_time_adj, $return_time_adj);
        }
        return with([
            'out_time_adj' => $out_time_adj,
            'return_time_adj' => $return_time_adj,
            'out_return_time' => $out_return_time,
            'out_time' => $request->out_time,
            'return_time' => $request->return_time,
        ]);
    }

    public function getBeginFinishTime($request)
    {
        // サービスクラスを定義
        $PunchBeginService = new PunchBeginService;
        $PunchFinishInputService = new PunchFinishInputService;
        // 出勤時間調整を取得
        $begin_time_adj = $PunchBeginService->getBeginTimeAdj($request->begin_time, $request->punch_begin_type);
        // 退勤時間調整を取得
        $finish_time_adj = $PunchFinishInputService->getFinishTimeAdj($request->finish_time);
        return with([
            'begin_time_adj' => $begin_time_adj,
            'finish_time_adj' => $finish_time_adj,
            'begin_time' => $request->begin_time,
            'finish_time' => $request->finish_time,
        ]);
    }

    public function setSessionKintaiModifyInfo($out_return_time, $begin_finish_time, $rest_time, $no_rest_times, $working_time, $punch_begin_type)
    {
        // 外出時間
        session(['out_time' => $out_return_time['out_time']]);
        session(['out_time_adj' => $out_return_time['out_time_adj']]);
        // 戻り時間
        session(['return_time' => $out_return_time['return_time']]);
        session(['return_time_adj' => $out_return_time['return_time_adj']]);
        // 外出戻り時間
        session(['out_return_time' => $out_return_time['out_return_time']]);
        // 出勤時間
        session(['begin_time' => $begin_finish_time['begin_time']]);
        session(['begin_time_adj' => $begin_finish_time['begin_time_adj']]);
        // 退勤時間
        session(['finish_time' => $begin_finish_time['finish_time']]);
        session(['finish_time_adj' => $begin_finish_time['finish_time_adj']]);
        // 休憩時間
        session(['rest_time' => $rest_time]);
        // 休憩未取得回数
        session(['no_rest_times' => $no_rest_times]);
        // 稼働時間
        session(['working_time' => $working_time]);
        // 早出フラグ
        session(['punch_begin_type' => $punch_begin_type]);
        return;
    }

    // 修正情報を勤怠テーブルに更新
    public function updatePunchModifyKintai($request, $over_time)
    {
        // 早出フラグを取得(リクエストパラメータがある = 早出となる) ※早出は1
        $is_early_worked = is_null(session('punch_begin_type')) ? 0 : 1;
        Kintai::where('kintai_id', session('kintai_id'))->update([
            'begin_time' => session('begin_time'),
            'begin_time_adj' => session('begin_time_adj'),
            'finish_time' => session('finish_time'),
            'finish_time_adj' => session('finish_time_adj'),
            'rest_time' => $request->rest_time,
            'no_rest_time' => $request->no_rest_time,
            'out_time' => session('out_time'),
            'out_time_adj' => session('out_time_adj'),
            'return_time' => session('return_time'),
            'return_time_adj' => session('return_time_adj'),
            'out_return_time' => session('out_return_time'),
            'working_time' => $request->working_time * 60, // 0.25単位から分単位に変換
            'over_time' => $over_time * 60, // 0.25単位から分単位に変換
            'is_early_worked' => $is_early_worked,
            'is_modified' => 1,
        ]);
        return;
    }

    // 荷主稼働時間の情報を勤怠詳細テーブルに追加（修正前は削除）
    public function addPunchModifyForKintaiDetail($working_time_input)
    {
        // 修正前のレコードを削除
        kintaiDetail::where('kintai_id', session('kintai_id'))->delete();
        // 荷主稼働時間の要素分だけループ処理
        foreach($working_time_input as $key => $value){
            KintaiDetail::create([
                'kintai_detail_id' => session('kintai_id').'-'.$key,
                'kintai_id' => session('kintai_id'),
                'customer_id' => $key,
                'customer_working_time' => $value * 60, // 0.25単位から分単位に変換
            ]);
        }
        return;
    }

    public function removeSessionKintaiModifyInfo()
    {
        // セッションを削除
        session()->forget([
            'out_time',
            'out_time_adj',
            'return_time',
            'return_time_adj',
            'out_return_time',
            'begin_time',
            'begin_time_adj',
            'finish_time',
            'finish_time_adj',
            'rest_time',
            'no_rest_times',
            'working_time',
            'punch_begin_type',
        ]);
        return;
    }
}