<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;

    Public function customers()
    {
        // Customerモデルのデータを引っ張てくる
        return $this->hasMany('App\Models\Customer', 'customer_group_id', 'customer_group_id');
    }
}
