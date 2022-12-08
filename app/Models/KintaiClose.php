<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KintaiClose extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'kintai_close_id';
    // オートインクリメント無効化
    public $incrementing = false;

    // 操作するカラムを許可
    protected $fillable = [
        'kintai_close_id',
        'close_date',
        'base_id',
    ];
}
