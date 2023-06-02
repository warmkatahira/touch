<?php

namespace App\Http\Controllers\SystemMgt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SystemMgt\UserMgtService;
use App\Models\User;
use App\Models\Base;
use App\Models\Role;
use App\Http\Requests\UserModifyRequest;

class UserMgtController extends Controller
{
    public function index()
    {
        // インスタンス化
        $UserMgtService = new UserMgtService;
        // ユーザー情報を取得
        $users = User::getAll()->get();
        return view('system_mgt.user_mgt.index')->with([
            'users' => $users,
        ]);
    }

    public function detail(Request $request)
    {
        // インスタンス化
        $UserMgtService = new UserMgtService;
        // ユーザー情報を取得
        $user = User::getSpecify($request->id)->first();
        // 権限情報を取得
        $roles = Role::getAll()->get();
        // 拠点情報を取得
        $bases = Base::getAll()->get();
        return view('system_mgt.user_mgt.detail')->with([
            'user' => $user,
            'roles' => $roles,
            'bases' => $bases,
        ]);
    }

    public function modify(UserModifyRequest $request)
    {
        // インスタンス化
        $UserMgtService = new UserMgtService;
        // ユーザー情報を更新
        $UserMgtService->modifyUser($request);
        return back();
    }
}
