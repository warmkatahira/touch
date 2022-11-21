<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\Customer;

class CsvExportService
{
    public function getExportData($request, $start_of_month, $end_of_month)
    {
        // 出力内容が「勤怠情報【通常】」
        if($request->export_content == 'kintai_normal'){
            $kintais = $this->getExportKintais($request->export_content, $request->search_base, $start_of_month, $end_of_month);
            $export = $this->getExportDataKintaiNormal($kintais);
        }
        // 出力内容が「勤怠情報【荷主稼働時間別】」
        if($request->export_content == 'kintai_by_customer_working_time'){
            $kintais = $this->getExportKintais($request->export_content, $request->search_base, $start_of_month, $end_of_month);
            $export = $this->getExportDataKintaiByCustomerWorkingTime($kintais);
        }
        // 出力内容が「荷主稼働時間」
        if($request->export_content == 'customer_working_time'){
            $customer_working_time = $this->getExportCustomerWorkingTime($request->search_base, $start_of_month, $end_of_month);
            $export = $this->getExportDataCustomerWorkingTime($customer_working_time);
        }
        return $export;
    }

    public function getExportKintais($export_content, $base_id, $start_of_month, $end_of_month)
    {
        // 出力に必要なテーブルを結合し、条件を適用
        $kintais = Kintai::join('employees', 'employees.employee_no', 'kintais.employee_no')
                    ->whereBetween('work_day', [$start_of_month, $end_of_month])
                    ->orderBy('work_day', 'asc')
                    ->orderBy('employees.employee_no', 'asc');
        // 拠点条件が「全社」以外の場合、条件を適用
        if($base_id != 0){
            $kintais = $kintais->where('base_id', session('search_base'));
        }
        // 出力内容が「荷主稼働時間別」であれば追加でテーブルを結合
        if($export_content == 'kintai_by_customer_working_time'){
            $kintais = $kintais->join('kintai_details', 'kintai_details.kintai_id', 'kintais.kintai_id')
                        ->join('customers', 'customers.customer_id', 'kintai_details.customer_id');
        }
        return $kintais;
    }

    public function getExportDataKintaiNormal($kintais)
    {
        // 出力する情報を取得
        $export = $kintais->select(
            DB::raw(
                'work_day as 出勤日,
                employees.employee_no as 従業員番号,
                employee_name as 従業員名,
                begin_time_adj as 出勤時間,
                finish_time_adj as 退勤時間,
                out_time_adj as 外出時間,
                return_time_adj as 戻り時間,
                out_return_time / 60 as 外出戻り時間,
                rest_time / 60 as 休憩取得時間,
                no_rest_time / 60 as 休憩未取得時間,
                working_time / 60 as 稼働時間,
                over_time / 60 as 残業時間,
                is_early_worked as 早出出勤,
                is_modified as 打刻修正,
                is_manual_punched as 手動打刻,
                manager_checked_at as 管理者確認'
            ))->get();
        $file_name = "勤怠情報【通常】";
        return compact('export', 'file_name');
    }

    public function getExportDataKintaiByCustomerWorkingTime($kintais)
    {
        // 出力する情報を取得
        $export = $kintais->select(
            DB::raw(
                'work_day as 出勤日,
                employees.employee_no as 従業員番号,
                employee_name as 従業員名,
                customer_name as 荷主名,
                customer_working_time / 60 as 荷主稼働時間'
            ))->get();
        $file_name = "勤怠情報【荷主稼働時間別】";
        return compact('export', 'file_name');
    }

    public function getExportCustomerWorkingTime($base_id, $start_of_month, $end_of_month)
    {
        // 出力に必要なテーブルを結合し、条件を適用
        $customer_working_time = Kintai::join('kintai_details', 'kintai_details.kintai_id', 'kintais.kintai_id')
                                    ->join('customers', 'customers.customer_id', 'kintai_details.customer_id')
                                    ->join('bases', 'bases.base_id', 'customers.control_base_id')
                                    ->whereBetween('work_day', [$start_of_month, $end_of_month])
                                    ->select(DB::raw("sum(customer_working_time) as total_customer_working_time, customers.customer_id, DATE_FORMAT(work_day, '%Y年%m月') as date, base_id"))
                                    ->groupBy('customers.customer_id', 'date');
        // 拠点条件が「全社」以外の場合、条件を適用
        if($base_id != 0){
            $customer_working_time = $customer_working_time->where('base_id', $base_id);
        }
        // 拠点条件の全ての荷主が出力されるように調整
        $customer_working_time = Customer::
            leftJoinSub($customer_working_time, 'TIME', function ($join) {
                $join->on('customers.customer_id', '=', 'TIME.customer_id');
            })
            ->join('bases', 'bases.base_id', 'customers.control_base_id')
            ->select('TIME.total_customer_working_time', 'base_name', 'TIME.date', 'customers.*', 'bases.base_name')
            ->orderBy('TIME.total_customer_working_time', 'desc');
        // 拠点条件が「全社」以外の場合、条件を適用
        if($base_id != 0){
            $customer_working_time = $customer_working_time->where('control_base_id', $base_id);
        }
        return $customer_working_time;
    }

    public function getExportDataCustomerWorkingTime($customer_working_time)
    {
        // 出力する情報を取得
        $export = $customer_working_time->select(
            DB::raw(
                "date as 対象年月,
                base_name as 拠点,
                customer_name as 荷主名,
                total_customer_working_time / 60 as 荷主稼働時間"
            ))->get();
        $file_name = "荷主稼働時間";
        return compact('export', 'file_name');
    }
}