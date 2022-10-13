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
    protected $fillable = ['kintai_id', 'employee_no', 'work_day', 'begin_time', 'begin_time_adj', 'out_return_time', 'early_work_enabled'];

    // 勤怠から従業員情報を取得
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_no', 'employee_no');
    }
}
