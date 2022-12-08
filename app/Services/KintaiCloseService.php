<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kintai;
use App\Models\Employee;
use App\Models\KintaiClose;
use Carbon\Carbon;

class KintaiCloseService
{
    public function getNotCloseKintai()
    {
        // 自拠点勤怠でロックがかかっていない(=未提出)情報を取得
        $not_close_kintais = Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                    ->whereNull('locked_at')
                    ->where('base_id', Auth::user()->base_id)
                    ->select(DB::raw("DATE_FORMAT(work_day, '%Y-%m') as date"))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
        return $not_close_kintais;
    }

    // 指定された年月の勤怠提出情報を取得
    public function checkKintaiClose($close_date)
    {
        $kintai_close = KintaiClose::where('close_date', $close_date)
                            ->where('base_id', Auth::user()->base_id)
                            ->first();
        return $kintai_close;
    }

    public function checkManagerCheckComplete($start_of_month, $end_of_month)
    {
        // 指定された年月かつ自拠点勤怠で管理者確認が未実施の勤怠情報を取得
        $not_close_kintais = Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                    ->whereBetween('work_day', [$start_of_month , $end_of_month])
                    ->whereNull('manager_checked_at')
                    ->where('base_id', Auth::user()->base_id)
                    ->count();
        return $not_close_kintais;
    }

    public function addKintaiClose($close_date)
    {
        // 勤怠提出テーブルを追加
        KintaiClose::create([
            'kintai_close_id' => Auth::user()->base_id .'-'. $close_date,
            'close_date' => $close_date,
            'base_id' => Auth::user()->base_id,
        ]);
        return;
    }

    public function updateLockedAt($start_of_month, $end_of_month)
    {
        // 指定した月の勤怠のロック日時を更新
        Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                    ->whereBetween('work_day', [$start_of_month , $end_of_month])
                    ->where('base_id', Auth::user()->base_id)->update([
            'locked_at' => Carbon::now(),
        ]);
        return;
    }
}