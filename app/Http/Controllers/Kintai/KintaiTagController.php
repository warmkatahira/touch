<?php

namespace App\Http\Controllers\Kintai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KintaiTagService;

class KintaiTagController extends Controller
{
    public function register(Request $request)
    {
        // サービスクラスを定義
        $KintaiTagService = new KintaiTagService;
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
