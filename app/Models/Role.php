<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'role_id';
    // オートインクリメント無効化
    public $incrementing = false;
    // 全て取得
    public static function getAll()
    {
        return self::orderBy('role_id', 'asc');
    }
}
