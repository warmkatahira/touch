<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Base;

class UserMgtService
{
    public function getUsers()
    {
        // ユーザー情報を取得
        $users = User::all();
        return $users;
    }

    public function getUser($id)
    {
        // ユーザー情報を取得
        $user = User::where('id', $id)->first();
        return $user;
    }

    public function getRoles()
    {
        // ロール情報を取得
        $roles = Role::all();
        return $roles;
    }

    public function getBases()
    {
        // 拠点情報を取得
        $bases = Base::all();
        return $bases;
    }

    public function modifyUser($request)
    {
        // レコードを更新
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'role_id' => $request->role,
            'base_id' => $request->base,
            'status' => $request->status,
        ]);
        return;
    }
}