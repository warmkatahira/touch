<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\KintaiReportOutputService;
use App\Services\CommonService;

class KintaiReportOutputController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $KintaiReportOutputService = new KintaiReportOutputService;
        // 拠点情報を取得
        $bases = $KintaiReportOutputService->getPulldownBase();
        return view('kintai_report_output.index')->with([
            'bases' => $bases,
        ]);
    }

    public function output(Request $request)
    {
        // サービスクラスを定義
        $KintaiReportOutputService = new KintaiReportOutputService;
        $CommonService = new CommonService;
        // 月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($request->month);
        // 月の情報を取得
        $month_date = $KintaiReportOutputService->getMonthDate($start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 出力対象の従業員を取得
        $employees = $KintaiReportOutputService->getOutputEmployee($request->base);
        // 出力する勤怠情報を取得
        $kintais = $KintaiReportOutputService->getOutputKintaiNormal($month_date['month_date'], $employees, $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        // 出力対象の営業所情報を取得
        $base = $KintaiReportOutputService->getBase($request->base);
        // ファイル名を取得
        $filename = $KintaiReportOutputService->getOutputFileName($request->month, $base['base']['base_name']);
        // PDF出力ビューに情報を渡す
        $pdf = $KintaiReportOutputService->passOutputInfo($kintais, $request->month, $base);
        // ファイル名を設定してPDFをダウンロード
        return $pdf->download($filename);
    }
}
