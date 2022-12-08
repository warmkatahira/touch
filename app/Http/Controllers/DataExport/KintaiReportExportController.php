<?php

namespace App\Http\Controllers\DataExport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\KintaiReportExportService;
use App\Services\CommonService;

class KintaiReportExportController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        // 拠点情報を取得
        $bases = $CommonService->getBases(false, false);
        return view('data_export.kintai_report_export.index')->with([
            'bases' => $bases,
        ]);
    }

    public function Export(Request $request)
    {
        // サービスクラスを定義
        $KintaiReportExportService = new KintaiReportExportService;
        $CommonService = new CommonService;
        // 月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($request->month);
        // 月の情報を取得
        $month_date = $KintaiReportExportService->getMonthDate($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 出力対象の従業員を取得
        $employees = $KintaiReportExportService->getExportEmployee($request->base);
        // 出力する勤怠情報を取得
        $kintais = $KintaiReportExportService->getExportKintai($month_date['month_date'], $employees, $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 週40時間超過情報を取得
        $over40 = $KintaiReportExportService->getOver40($month_date['month_date'], $employees, $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 出力対象の営業所情報を取得
        $base = $KintaiReportExportService->getBase($request->base);
        // 対象月の祝日を取得
        $holidays = $KintaiReportExportService->getHolidays($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // ファイル名を取得
        $filename = $KintaiReportExportService->getExportFileName($request->month, $base['base']['base_name']);
        // PDF出力ビューに情報を渡す
        $pdf = $KintaiReportExportService->passExportInfo($kintais, $request->month, $base, $over40, $holidays);
        // ファイル名を設定してPDFをダウンロード
        return $pdf->download($filename);
    }
}
