<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'customer_group_id';

    // 操作するカラムを許可
    protected $fillable = [
        'base_id',
        'customer_group_name',
        'customer_group_order',
    ];
    // customersテーブルとのリレーション
    Public function customers()
    {
        // Customerモデルのデータを引っ張てくる
        return $this->hasMany(Customer::class, 'customer_group_id', 'customer_group_id');
    }

    // 荷主グループ情報から拠点情報を取得
    public function base()
    {
        return $this->belongsTo(Base::class, 'base_id', 'base_id');
    }

    // 登録されている荷主数をカウント
    public function setting_customer_count()
    {
        return $this->hasMany(Customer::class, 'customer_group_id', 'customer_group_id')->count();
    }
    // 指定した拠点の荷主グループを取得
    public static function getSpecifyBase($base_id)
    {
        return self::where('base_id', $base_id)->orderBy('customer_group_order', 'asc');
    }
}
