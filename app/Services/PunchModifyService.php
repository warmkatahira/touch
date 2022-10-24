<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\PunchOutService;
use App\Services\PunchReturnService;

class PunchModifyService
{
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
        ]);
    }
}