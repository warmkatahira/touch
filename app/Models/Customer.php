<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'customer_id';
    // オートインクリメント無効化
    public $incrementing = false;
    Public function customer_group()
    {
        // CustomerGroupモデルのデータを引っ張てくる
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id', 'customer_group_id');
    }
    // 荷主から拠点情報を取得
    public function base()
    {
        return $this->belongsTo(Base::class, 'control_base_id', 'base_id');
    }
    // 指定した荷主を取得
    public static function getSpecify($customer_id)
    {
        return self::where('customer_id', $customer_id);
    }
}
