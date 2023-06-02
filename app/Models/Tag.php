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
    // 指定されたタグを取得
    public static function getSpecify($tag_id)
    {
        return self::where('tag_id', $tag_id);
    }
    // 指定された所有権限のタグを取得
    public static function getSpecifyOwnerRole($owner_role_id)
    {
        return self::where('owner_role_id', $owner_role_id);
    }
}
