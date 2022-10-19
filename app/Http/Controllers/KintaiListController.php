<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KintaiListService;

class KintaiListController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $KintaiListService = new KintaiListService;
        // 検索条件が格納されているセッションをクリア
        $KintaiListService->deleteSearchSession();
        // 初期条件をセット
        $KintaiListService->setDefaultCondition();
        // 検索条件と一致した勤怠を取得
        $kintais = $KintaiListService->getKintaiSearch();
        // 検索条件に使用するプルダウン情報を取得
        $pulldown = $KintaiListService->getPulldown();
        return view('kintai_list.index')->with([
            'kintais' => $kintais,
            'bases' => $pulldown['bases'],
            'employee_categories' => $pulldown['employee_categories'],
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $KintaiListService = new KintaiListService;
        // 検索条件が格納されているセッションをクリア
        $KintaiListService->deleteSearchSession();
        // 検索条件をセッションに格納
        $KintaiListService->getSearchCondition($request);
        // 出勤日の条件が正しいか確認
        $error_info = $KintaiListService->checkWorkdayCondition();
        // 出勤日の条件エラーがなければ勤怠を取得
        if(is_null($error_info)){
            // 検索条件と一致した勤怠を取得
            $kintais = $KintaiListService->getKintaiSearch();
            session()->forget('alert_danger');
        }
        // 条件エラーがあればメッセージを表示
        if(!is_null($error_info)){
            session()->flash('alert_danger', $error_info);
        }
        // 検索条件に使用するプルダウン情報を取得
        $pulldown = $KintaiListService->getPulldown();
        return view('kintai_list.index')->with([
            'kintais' => $kintais,
            'bases' => $pulldown['bases'],
            'employee_categories' => $pulldown['employee_categories'],
        ]);
    }
}
