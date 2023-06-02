<?php

namespace App\Http\Controllers\SystemMgt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SystemMgt\TagMgtService;
use App\Models\Role;
use App\Models\Tag;

class TagMgtController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグ情報を取得
        $tags = Tag::getAll()->get();
        return view('system_mgt.tag_mgt.index')->with([
            'tags' => $tags,
        ]);
    }

    public function detail(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグ情報を取得
        $tag = Tag::getSpecify($request->tag_id)->first();
        // ロール情報を取得
        $roles = Role::getAll()->get();
        return view('system_mgt.tag_mgt.detail')->with([
            'tag' => $tag,
            'roles' => $roles,
        ]);
    }

    public function register_index()
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // ロール情報を取得
        $roles = Role::getAll()->get();
        return view('system_mgt.tag_mgt.register')->with([
            'roles' => $roles,
        ]);
    }

    public function register(Request $request)
    {
        // サービスクラスを定義
        $TagMgtService = new TagMgtService;
        // タグを追加
        $TagMgtService->createTag($request);
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
