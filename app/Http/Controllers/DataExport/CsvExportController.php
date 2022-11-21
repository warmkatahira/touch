<?php

namespace App\Http\Controllers\DataExport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CommonService;
use App\Services\CsvExportService;
use Rap2hpoutre\FastExcel\FastExcel;

class CsvExportController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        // 拠点を取得
        $bases = $CommonService->getBases(true);
        // 従業員区分を取得
        $employee_categories = $CommonService->getEmployeeCategories(true);
        return view('data_export.csv_export.index')->with([
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function Export(Request $request)
    {
        // サービスクラスを定義
        $CsvExportService = new CsvExportService;
        $CommonService = new CommonService;
        // 月初・月末の日付を取得
        $start_end_of_month = $CommonService->getStartEndOfMonth($request->search_month);
        // 出力する情報を取得
        $export = $CsvExportService->getExportData($request, $start_end_of_month['start_of_month'], $start_end_of_month['end_of_month']);
        return (new FastExcel($export['export']))->download('【Touch】'.$export['file_name'].'【対象年月='.$request->search_month.'】_' . new Carbon('now') . '.csv');
    }
}
