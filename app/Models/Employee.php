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
        // 今日の日付の勤怠が無い従業員
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'));
    }

    // 退勤打刻が可能な対象を取得
    Public function punch_finish_targets()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 今日の日付の勤怠があって、退勤時刻がNullかつ外出中フラグがNullの従業員
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'))
                ->whereNull('finish_time')
                ->whereNull('out_enabled');
    }

    // 外出打刻が可能な対象を取得
    public function punch_out_targets()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 今日の日付の勤怠があって、退勤時間がNullかつ外出時間がNullの従業員
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'))
                ->whereNull('finish_time')
                ->whereNull('out_time');
    }

    // 戻り打刻が可能な対象を取得
    public function punch_return_targets()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 今日の日付の勤怠があって、外出時間がNot Nullかつ戻り時間がNullの従業員
        return $this->hasMany('App\Models\Kintai', 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'))
                ->whereNotNull('out_time')
                ->whereNull('return_time');
    }

    // 従業員情報から拠点情報を取得
    public function base()
    {
        return $this->belongsTo('App\Models\Base', 'base_id', 'base_id');
    }

    // 従業員情報から従業員区分情報を取得
    public function employee_category()
    {
        return $this->belongsTo('App\Models\EmployeeCategory', 'employee_category_id', 'employee_category_id');
    }
}
