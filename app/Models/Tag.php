<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'tag_id';

    // 操作するカラムを許可
    protected $fillable = [
        'owner_role_id',
        'tag_name',
    ];

    // タグからロール情報を取得
    public function role()
    {
        return $this->belongsTo(Role::class, 'owner_role_id', 'role_id');
    }

    // 勤怠に登録されているタグ数をカウント
    public function kintai_tags_count()
    {
        return $this->hasMany(KintaiTag::class, 'tag_id', 'tag_id')->count();
    }
}
