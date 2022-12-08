<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KintaiDetail extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'kintai_detail_id';
    // オートインクリメント無効化
    public $incrementing = false;

    // 操作するカラムを許可
    protected $fillable = ['kintai_detail_id', 'kintai_id', 'customer_id', 'customer_working_time', 'is_supported'];

    // 勤怠から荷主情報を取得
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'customer_id');
    }
}
