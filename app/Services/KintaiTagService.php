<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\KintaiTag;

class KintaiTagService
{
    // 既に存在するタグではないか確認
    public function checkKintaiTagAddable($kintai_id, $tag)
    {
        // 追加条件で抽出
        $kintai_tag = KintaiTag::where('kintai_id', $kintai_id)
                        ->where('tag_id', $tag)
                        ->first();
        return $kintai_tag;
    }

    // タグ追加処理
    public function addKintaiTag($kintai_id, $tag)
    {
        // タグを追加
        KintaiTag::create([
            'kintai_tag_id' => $kintai_id .'-'. $tag,
            'kintai_id' => $kintai_id,
            'register_user_id' => Auth::user()->id,
            'tag_id' => $tag,
        ]);
        return;
    }

    // タグ削除処理
    public function deleteKintaiTag($kintai_tag_id)
    {
        // タグを削除
        KintaiTag::where('kintai_tag_id', $kintai_tag_id)->delete();
        return;
    }
}