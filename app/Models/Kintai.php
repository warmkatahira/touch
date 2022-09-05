<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kintai extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'kintai_id';

    // 操作するカラムを許可
    protected $fillable = ['employee_no', 'work_day', 'begin_time', 'begin_time_adj', 'created_at', 'updated_at'];
}
