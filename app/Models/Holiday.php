<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'holiday';
    // オートインクリメント無効化
    public $incrementing = false;
}
