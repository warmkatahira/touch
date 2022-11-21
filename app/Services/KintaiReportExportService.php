<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Base;
use App\Models\Kintai;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use Carbon\Carbon;

class KintaiReportExportService
{
    public function getMonthDate($start_of_month, $end_of_month)
    {
        // 月の日数を取得
        $days = new Carbon($start_of_month);
        $days = $days->daysInMonth;
        // 配列をセット
        $month_date = [];
        // 月初の日付をインスタンス化
        $start_day_for = new Carbon($start_of_month);
        $start_day_for = $start_day_for->startOfMonth();
        // for文で月の日数をループ
        for($i = 0; $i < $days; $i++){
            // 月初の日付をインスタンス化
            $day = new Carbon($start_day_for);
            // 配列に月初の日付+日数の日付をセット
            $month_date[$i] = $day->addDays($i)->toDateString();
        }
        return compact('month_date');
    }

    public function getExportEmployee($base_id)
    {
        // 出力対象の従業員を取得
        $employees = Employee::where('employees.base_id', $base_id)
                        ->join('bases', 'employees.base_id', 'bases.base_id')
                        ->select('employees.employee_no', 'employees.employee_name', 'bases.base_name')
                        ->get();
        return $employees;
    }

    public function getExportKintaiNormal($month_date, $employees, $start_day, $end_day)
    {
        
        // 従業員分だけループ処理
        foreach($employees as $employee){
            // 勤怠情報を格納する配列をセット
            $kintais[$employee->employee_no] = [];
            $kintais[$employee->employee_no]['employee_name'] = $employee->employee_name;
            $kintais[$employee->employee_no]['base_name'] = $employee->base_name;
            // 月の日数分だけループ処理
            foreach($month_date as $date){
                // 勤怠情報と従業員情報を結合して取得
                $kintai = Kintai::where('employee_no', $employee->employee_no)->where('work_day', $date)->first();
                // 配列に格納
                $kintais[$employee->employee_no]['kintai'][$date] = $kintai;
            }
            // 稼働日数を取得（配列の数 - 配列のnullの数）
            $kintais[$employee->employee_no]['working_days'] = count($kintais[$employee->employee_no]['kintai']) - count(array_keys($kintais[$employee->employee_no]['kintai'], null));
            // 総稼働時間を取得
            $kintais[$employee->employee_no]['total_working_time'] = Kintai::where('employee_no', $employee->employee_no)
                                                                        ->whereBetween('work_day', [$start_day, $end_day])
                                                                        ->sum('working_time');
            // 総残業時間を取得
            $kintais[$employee->employee_no]['total_over_time'] = Kintai::where('employee_no', $employee->employee_no)
                                                                        ->whereBetween('work_day', [$start_day, $end_day])
                                                                        ->sum('over_time');
        }
        return $kintais;
    }

    public function getBase($base_id)
    {
        // 出力対象の営業所を取得
        $base = Base::where('base_id', $base_id)->first();
        // 従業員区分を取得
        $employee_categories = EmployeeCategory::all();
        // 従業員区分毎の人数を取得
        foreach($employee_categories as $employee_category){
            $employee_count = Employee::where('base_id', $base_id)
                                ->where('employee_category_id', $employee_category->employee_category_id)
                                ->count();
            $total_employee[$employee_category->employee_category_name] = $employee_count;
        }
        return compact('base', 'total_employee');
    }

    public function getExportFileName($month, $base_name)
    {
        // 出力年月をフォーマット
        $month = new Carbon($month);
        $month = $month->format('Y年m月');
        // ファイル名を作成
        $filename = '【'.$base_name.'】勤怠表_'.$month.'.pdf';
        return $filename;
    }

    public function passExportInfo($kintais, $month, $base)
    {
        // PDF出力ビューに情報を渡す
        $pdf = PDF::loadView('data_export.kintai_report_export.report', compact('kintais', 'month', 'base'));
        return $pdf;
    }
}