<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\CommonService;
use App\Services\Other\ThisMonthKintaiService;
use App\Services\KintaiReportExportService;

class ThisMonthKintaiController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        $ThisMonthKintaiService = new ThisMonthKintaiService;
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 今月の月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($nowDate);
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
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 今月の月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($nowDate);
        // 従業員の情報を取得
        $employee = Employee::getSpecify($request->employee_no)->first();
        // 当月の情報を取得
        $month_date = $KintaiReportExportService->getMonthDate($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 勤怠表に使用する情報を取得
        $kintais = $KintaiReportExportService->getExportKintai($month_date['month_date'], Employee::getSpecify($request->employee_no), $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        return view('this_month_kintai.detail')->with([
            'kintais' => $kintais,
            'employee' => $employee,
        ]);
    }
}
