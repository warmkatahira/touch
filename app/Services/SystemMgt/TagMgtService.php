<?php

namespace App\Services\SystemMgt;

use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Role;

class TagMgtService
{
    public function createTag($request)
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