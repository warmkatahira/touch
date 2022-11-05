<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OverTimeRankService;

class OverTimeRankController extends Controller
{
    public function index()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // サービスクラスを定義
        $OverTimeRankService = new OverTimeRankService;
        // 正社員の残業時間情報を取得
        $employees = $OverTimeRankService->getOverTimeData();
        return view('over_time_rank.index')->with([
            'employees' => $employees,
        ]);
    }
}
