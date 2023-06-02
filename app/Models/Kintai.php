<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kintai extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'kintai_id';
    // オートインクリメント無効化
    public $incrementing = false;

    // 操作するカラムを許可
    protected $fillable = [
        'kintai_id',
        'employee_no',
        'work_day',
        'begin_time',
        'begin_time_adj',
        'finish_time',
        'finish_time_adj',
        'out_time',
        'out_time_adj',
        'return_time',
        'return_time_adj',
        'out_return_time',
        'is_early_worked',
        'rest_time',
        'no_rest_time',
        'add_rest_time',
        'working_time',
        'over_time',
        'is_modified',
        'is_manual_punched',
        'locked_at',
    ];
    // employeesテーブルとのリレーション
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_no', 'employee_no');
    }
    // 全て取得
    public static function getAll()
    {
        return self::orderBy('employee_no', 'asc');
    }
    // 指定した勤怠を取得
    public static function getSpecify($kintai_id)
    {
        return self::where('kintai_id', $kintai_id);
    }
}
