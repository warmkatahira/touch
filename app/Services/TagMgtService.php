<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Role;

class TagMgtService
{
    public function getTags()
    {
        // タグ情報を取得
        $tags = Tag::all();
        return $tags;
    }

    public function getTag($tag_id)
    {
        // タグ情報を取得
        $tag = Tag::where('tag_id', $tag_id)->first();
        return $tag;
    }

    public function getRoles()
    {
        // ロール情報を取得
        $roles = Role::all();
        return $roles;
    }

    public function addTag($request)
    {
        // レコードを追加
        Tag::create([
            'owner_role_id' => $request->owner_role_id,
            'tag_name' => $request->tag_name,
        ]);
        return;
    }

    public function deleteTag($tag_id)
    {
        // タグを削除
        Tag::where('tag_id', $tag_id)->delete();
        return;
    }

    public function modifyTag($request)
    {
        // レコードを更新
        Tag::where('tag_id', $request->tag_id)->update([
            'owner_role_id' => $request->owner_role_id,
            'tag_name' => $request->tag_name,
        ]);
        return;
    }
}