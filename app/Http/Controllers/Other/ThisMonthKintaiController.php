<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Kintai;
use App\Services\CommonService;
use App\Services\ThisMonthKintaiService;
use App\Services\KintaiReportExportService;

class ThisMonthKintaiController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        $ThisMonthKintaiService = new ThisMonthKintaiService;
        // 今月の月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth(Carbon::now());
        // 月単位で勤怠を集計・取得
        $month_kintais = $ThisMonthKintaiService->getMonthKintai($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        return view('this_month_kintai.index')->with([
            'month_kintais' => $month_kintais,
        ]);
    }

    public function detail(Request $request)
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        $ThisMonthKintaiService = new ThisMonthKintaiService;
        $KintaiReportExportService = new KintaiReportExportService;
        // 今月の月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth(Carbon::now());
        // 従業員の情報を取得
        $employee = $CommonService->getEmployee($request->employee_no);
        // 当月の情報を取得
        $month_date = $KintaiReportExportService->getMonthDate($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 勤怠表に使用する情報を取得
        $kintais = $KintaiReportExportService->getOutputKintaiNormal($month_date['month_date'], $employee['employees'], $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        return view('this_month_kintai.detail')->with([
            'kintais' => $kintais,
            'employee' => $employee['employee']
        ]);
    }
}
