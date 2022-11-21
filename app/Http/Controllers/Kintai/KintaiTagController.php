<?php

namespace App\Http\Controllers\Kintai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KintaiTagService;
use App\Services\KintaiCommonService;

class KintaiTagController extends Controller
{
    public function register(Request $request)
    {
        // サービスクラスを定義
        $KintaiTagService = new KintaiTagService;
        $KintaiCommonService = new KintaiCommonService;
        // 追加対象の勤怠を取得
        $kintai = $KintaiCommonService->getKintai($request->kintai_id);
        // 既に存在するタグではないか確認
        $kintai_tag = $KintaiTagService->checkKintaiTagAddable($request->kintai_id, $request->tag);
        // レコードが取得できていれば存在するので処理を中断
        if(!is_null($kintai_tag)){
            session()->flash('alert_danger', '既に存在するタグです。');
            return back();
        }
        // タグ追加処理
        $KintaiTagService->addKintaiTag($request->kintai_id, $request->tag);
        return back();
    }

    public function delete(Request $request)
    {
        // サービスクラスを定義
        $KintaiTagService = new KintaiTagService;
        // タグを削除
        $KintaiTagService->deleteKintaiTag($request->kintai_tag_id);
        return back();
    }
}
