<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Kintai;

class ThisMonthKintaiService
{
    public function getStartEndOfMonth()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 月初と月末の日付を取得
        $start_of_month = $nowDate->startOfMonth()->toDateString();
        $end_of_month = $nowDate->endOfMonth()->toDateString();
        return with([
            'start_of_month' => $start_of_month,
            'end_of_month' => $end_of_month,
        ]);
    }

    public function getMonthKintai($start_of_month, $end_of_month)
    {
        // 自拠点従業員の当月の勤怠を集計
        $this_month_kintais = Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                                ->where('base_id', Auth::user()->base_id)
                                ->whereBetween('work_day', [$start_of_month , $end_of_month])
                                ->select(DB::raw("sum(working_time) as total_working_time, sum(over_time) as total_over_time, employees.employee_no, DATE_FORMAT(work_day, '%Y-%m') as date"))
                                ->groupBy('employee_no', 'date');
        // 集計した勤怠を従業員テーブルと結合
        $month_kintais = Employee::
            leftJoinSub($this_month_kintais, 'KINTAIS', function ($join) {
                $join->on('employees.employee_no', '=', 'KINTAIS.employee_no');
            })
            ->where('employees.base_id', Auth::user()->base_id)
            ->join('bases', 'employees.base_id', 'bases.base_id')
            ->select('employees.employee_no', 'employees.employee_name', 'employees.employee_category_id', 'KINTAIS.total_working_time', 'KINTAIS.total_over_time', 'bases.base_name')
            ->orderBy('employees.employee_no', 'asc')
            ->get();
        return $month_kintais;
    }
}