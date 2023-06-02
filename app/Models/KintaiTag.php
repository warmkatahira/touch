<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KintaiTag extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'kintai_tag_id';
    // オートインクリメント無効化
    public $incrementing = false;

    // 操作するカラムを許可
    protected $fillable = [
        'kintai_tag_id',
        'kintai_id',
        'register_user_id',
        'tag_id',
    ];

    // 勤怠タグからタグを取得
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'tag_id');
    }
}
