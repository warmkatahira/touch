<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagMgtService;

class TagMgtController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグ情報を取得
        $tags = $TagMgtService->getTags();
        return view('tag_mgt.index')->with([
            'tags' => $tags,
        ]);
    }

    public function detail(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグ情報を取得
        $tag = $TagMgtService->getTag($request->tag_id);
        // ロール情報を取得
        $roles = $TagMgtService->getRoles();
        return view('tag_mgt.detail')->with([
            'tag' => $tag,
            'roles' => $roles,
        ]);
    }

    public function register_index()
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // ロール情報を取得
        $roles = $TagMgtService->getRoles();
        return view('tag_mgt.register')->with([
            'roles' => $roles,
        ]);
    }

    public function register(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグを追加
        $TagMgtService->addTag($request);
        return redirect()->route('tag_mgt.index');
    }

    public function delete(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグを削除
        $TagMgtService->deleteTag($request->tag_id);
        return redirect()->route('tag_mgt.index');
    }

    public function modify(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグ情報を更新
        $TagMgtService->modifyTag($request);
        return back();
    }
}
