<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Kintai;
use App\Services\ThisMonthKintaiService;

class KintaiCheckController extends Controller
{
    public function today_kintai_index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)
                        ->orderBy('employee_no')
                        ->get();
        return view('today_kintai.index')->with([
            'employees' => $employees,
        ]);
    }

    public function this_month_kintai_index()
    {
        // サービスクラスを定義
        $ThisMonthKintaiService = new ThisMonthKintaiService;
        // 今月の月初・月末の日付を取得
        $start_end_of_month = $ThisMonthKintaiService->getStartEndOfMonth();
        // 月単位で勤怠を集計・取得
        $month_kintais = $ThisMonthKintaiService->getMonthKintai($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        return view('this_month_kintai.index')->with([
            'month_kintais' => $month_kintais,
        ]);
    }
}
