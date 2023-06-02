<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'base_id';
    // オートインクリメント無効化
    public $incrementing = false;
    // 指定された拠点を取得
    public static function getSpecify($base_id)
    {
        return self::where('base_id', $base_id);
    }
}
