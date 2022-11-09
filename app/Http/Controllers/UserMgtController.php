<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserMgtService;

class UserMgtController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $UserMgtService = new UserMgtService;
        // ユーザー情報を取得
        $users = $UserMgtService->getUsers();
        return view('user_mgt.index')->with([
            'users' => $users,
        ]);
    }

    public function detail(Request $request)
    {
        // サービスクラスを定義
        $UserMgtService = new UserMgtService;
        // ユーザー情報を取得
        $user = $UserMgtService->getUser($request->id);
        // 権限情報を取得
        $roles = $UserMgtService->getRoles();
        // 拠点情報を取得
        $bases = $UserMgtService->getBases();
        return view('user_mgt.detail')->with([
            'user' => $user,
            'roles' => $roles,
            'bases' => $bases,
        ]);
    }

    public function modify(Request $request)
    {
        // サービスクラスを定義
        $UserMgtService = new UserMgtService;
        // ユーザー情報を更新
        $UserMgtService->modifyUser($request);
        return back();
    }
}
