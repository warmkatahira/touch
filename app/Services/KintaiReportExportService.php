<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Base;
use App\Models\Kintai;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\Holiday;
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
        // 出力対象の従業員を取得(getは以降の処理で実施)
        $employees = Employee::where('employees.base_id', $base_id)
                        ->join('bases', 'employees.base_id', 'bases.base_id')
                        ->select('employees.employee_no', 'employees.employee_name', 'bases.base_id', 'bases.base_name', 'employees.employee_category_id')
                        ->orderBy('employees.employee_no', 'asc');
        return $employees;
    }

    public function getExportKintai($month_date, $employees, $start_day, $end_day)
    {
        // 従業員分だけループ処理
        $employees = $employees->get();
        foreach($employees as $employee){
            // 勤怠情報を格納する配列をセット
            $kintais[$employee->employee_no] = [];
            $kintais[$employee->employee_no]['employee_name'] = $employee->employee_name;
            $kintais[$employee->employee_no]['base_id'] = $employee->base_id;
            $kintais[$employee->employee_no]['base_name'] = $employee->base_name;
            $kintais[$employee->employee_no]['employee_category_name'] = $employee->employee_category->employee_category_name;
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
            // 応援稼働時間を取得 
            $kintais[$employee->employee_no]['support_working_time'] = $this->getSupportWorkingTime($employee->employee_no, $start_day, $end_day);
            // 国民の祝日の総稼働時間を取得
            $kintais[$employee->employee_no]['national_holiday_total_working_time'] = $this->getNationalHolidayTotalWorkingTime($employee->employee_no, $start_day, $end_day);
        }
        // 出力するデータがなければ、nullを返す
        return isset($kintais) ? $kintais : null;
    }

    public function getSupportWorkingTime($employee_no, $start_day, $end_day)
    {
        // 従業員を取得
        $employee = Employee::where('employee_no', $employee_no);
        // 応援稼働時間を取得
        $support_working_times = Kintai::joinSub($employee, 'EMPLOYEE', function ($join) {
                    $join->on('kintais.employee_no', '=', 'EMPLOYEE.employee_no');
                })
                ->join('kintai_details', 'kintai_details.kintai_id', 'kintais.kintai_id')
                ->whereBetween('work_day', [$start_day, $end_day])
                ->where('kintai_details.customer_id', 'like', 'warm_%')
                ->join('customers', 'customers.customer_id', 'kintai_details.customer_id')
                ->select(DB::raw("sum(customer_working_time) as total_customer_working_time, EMPLOYEE.employee_no, kintai_details.customer_id, DATE_FORMAT(work_day, '%Y-%m') as date, customers.customer_name"))
                ->groupBy('EMPLOYEE.employee_no', 'customers.customer_id', 'date')
                ->orderBy('EMPLOYEE.employee_no', 'asc')
                ->orderBy('kintai_details.customer_id', 'asc')
                ->get();
        return $support_working_times;
    }

    // 国民の祝日に稼働した時間を取得
    public function getNationalHolidayTotalWorkingTime($employee_no, $start_day, $end_day)
    {
        // 従業員を取得
        $employee = Employee::where('employee_no', $employee_no);
        // 国民の祝日を取得
        $national_holidays = Holiday::whereBetween('holiday', [$start_day , $end_day])
                                ->where('is_national_holiday', 1);
        // 稼働時間を取得
        $national_holiday_total_working_time = Kintai::joinSub($employee, 'EMPLOYEE', function ($join) {
                    $join->on('kintais.employee_no', '=', 'EMPLOYEE.employee_no');
                })
                ->whereBetween('work_day', [$start_day, $end_day])
                ->joinSub($national_holidays, 'HOLIDAY', function ($join) {
                    $join->on('kintais.work_day', '=', 'HOLIDAY.holiday');
                })
                ->sum('working_time');
        return $national_holiday_total_working_time;
    }

    public function getOver40($month_date, $employees, $start_day, $end_day)
    {
        // 従業員数分だけループ処理
        foreach($employees->get() as $employee){
            // 従業員区分がパートのみを対象とする
            if($employee->employee_category_id == 2){
                // 情報を格納する配列をセット
                $over40[$employee->employee_no] = [];
                // 月の日数分だけループ処理
                foreach($month_date as $date){
                    // 日付をインスタンス化
                    $to_day = new Carbon($date);
                    // 日曜日だったら、週40時間超過情報を取得
                    if($to_day->isSunday()){
                        // 同週の月曜日の日付を取得
                        $from_day = new Carbon($to_day);
                        $from_day = $from_day->subDays(6);
                        // フォーマット変換
                        $from_day = $from_day->toDateString();
                        $to_day = $to_day->toDateString();
                        // 週40時間超過情報を取得
                        $over40[$employee->employee_no][$date] = Kintai::where('employee_no', $employee->employee_no)
                                                                    ->whereBetween('work_day', [$from_day , $to_day])
                                                                    ->select(DB::raw("sum(working_time) as total_working_time, sum(over_time) as total_over_time, (sum(working_time) - sum(over_time) - 2400) as over40, DATE_FORMAT(work_day, '%v') as date"))
                                                                    ->groupBy('employee_no', 'date')
                                                                    ->first();
                    }
                }
            }
        }
        return isset($over40) ? $over40 : array();
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

    public function getHolidays($start_day, $end_day)
    {
        // 対象月の祝日を取得
        $holidays = Holiday::whereBetween('holiday', [$start_day , $end_day])->get();
        // 配列に祝日を格納
        foreach($holidays as $holiday){
            $holiday_info[$holiday->holiday] = $holiday->holiday;
        }
        return isset($holiday_info) ? $holiday_info : array();
    }

    public function getTaiyoWorkingTimeAtHoliday($base, $month_date, $employees, $start_day, $end_day)
    {
        // 第1営業所のみ処理を実施
        if($base == 'warm_02'){
            // 指定された期間の国民の祝日を取得
            $national_holidays = Holiday::whereBetween('holiday', [$start_day, $end_day])
                                    ->where('is_national_holiday', 1);
            // 従業員数分だけループ処理
            foreach($employees->get() as $employee){
                // 従業員区分がパートのみを対象とする
                if($employee->employee_category_id == 2){
                    // 国民の祝日に大洋製薬の稼働がある日を取得
                    $kintais = Kintai::where('employee_no', $employee->employee_no)
                                    ->joinSub($national_holidays, 'HOLIDAY', function ($join) {
                                        $join->on('kintais.work_day', '=', 'HOLIDAY.holiday');
                                    })
                                    ->join('kintai_details', 'kintai_details.kintai_id', 'kintais.kintai_id')
                                    ->whereBetween('work_day', [$start_day, $end_day])
                                    ->where('kintai_details.customer_id', '10') // 大洋製薬のcustomer_idを設定
                                    ->select('kintais.work_day', 'kintais.employee_no')
                                    ->get();
                    // 配列に格納
                    foreach($kintais as $kintai){
                        $taiyo_working_times[$employee->employee_no][$kintai->work_day] = $kintai->work_day;
                    }
                }
            }
        }
        return isset($taiyo_working_times) ? $taiyo_working_times : array();
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

    public function passExportInfo($kintais, $month, $base, $over40, $holidays, $taiyo_working_times)
    {
        // PDF出力ビューに情報を渡す
        $pdf = PDF::loadView('data_export.kintai_report_export.report', compact('kintais', 'month', 'base', 'over40', 'holidays', 'taiyo_working_times'));
        return $pdf;
    }
}