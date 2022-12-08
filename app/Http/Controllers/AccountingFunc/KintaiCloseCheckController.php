<?php

namespace App\Http\Controllers\AccountingFunc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KintaiCloseCheckService;

class KintaiCloseCheckController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $KintaiCloseCheckService = new KintaiCloseCheckService;
        // 初期検索条件をセット
        $KintaiCloseCheckService->setDefaultCondition();
        // 指定された年月かつ自拠点勤怠の提出情報を取得
        $kintai_closes = $KintaiCloseCheckService->getKintaiCloseSearch();
        return view('accounting_func.kintai_close_check.index')->with([
            'kintai_closes' => $kintai_closes,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $KintaiCloseCheckService = new KintaiCloseCheckService;
        // 初期検索条件をセット
        $KintaiCloseCheckService->getSearchCondition($request->search_month);
        // 指定された年月かつ自拠点勤怠の提出情報を取得
        $kintai_closes = $KintaiCloseCheckService->getKintaiCloseSearch();
        return view('accounting_func.kintai_close_check.index')->with([
            'kintai_closes' => $kintai_closes,
        ]);
    }
}
