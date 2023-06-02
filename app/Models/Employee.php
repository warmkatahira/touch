<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonImmutable;
use App\Models\Kintai;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'employee_no';
    // オートインクリメント無効化
    public $incrementing = false;
    // 操作するカラムを許可
    protected $fillable = [
        'employee_no',
        'employee_name',
        'base_id',
        'employee_category_id',
        'monthly_workable_time_setting',
        'over_time_start_setting',
    ];
    // 出勤打刻が可能な対象を取得
    Public function punch_begin_targets()
    {
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 今日の日付の勤怠が無い従業員
        return $this->hasMany(Kintai::class, 'employee_no', 'employee_no')
                ->where('work_day', $nowDate->format('Y-m-d'));
    }
    // basesテーブルとのリレーション
    public function base()
    {
        return $this->belongsTo(Base::class, 'base_id', 'base_id');
    }
    // employee_categoriesテーブルとのリレーション
    public function employee_category()
    {
        return $this->belongsTo(EmployeeCategory::class, 'employee_category_id', 'employee_category_id');
    }
    // 指定された拠点を取得
    public static function getSpecify($employee_no)
    {
        return self::where('employee_no', $employee_no);
    }
}
