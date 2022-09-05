<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'employee_no';
    // オートインクリメント無効化
    public $incrementing = false;

    // 出勤打刻が可能な対象を取得
    Public function punch_begin_targets()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'));
    }

    // 退勤打刻が可能な対象を取得
    Public function punch_finish_targets()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'))
                ->whereNull('finish_time');
    }
}
