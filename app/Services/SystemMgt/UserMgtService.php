<?php

namespace App\Services\SystemMgt;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Base;

class UserMgtService
{
    public function modifyUser($request)
    {
        // レコードを更新
        User::getSpecify($request->id)->update([
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'base_id' => $request->base_id,
            'status' => $request->status,
        ]);
        return;
    }
}