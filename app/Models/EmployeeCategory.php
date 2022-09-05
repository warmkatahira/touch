<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'employee_category_id';
    // オートインクリメント無効化
    public $incrementing = false;
}
