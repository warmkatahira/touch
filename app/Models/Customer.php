<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'customer_id';

    Public function customer_group()
    {
        // CustomerGroupモデルのデータを引っ張てくる
        return $this->belongsTo('App\Models\CustomerGroup', 'customer_group_id');
    }
}
