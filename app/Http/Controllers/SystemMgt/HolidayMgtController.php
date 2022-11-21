<?php

namespace App\Http\Controllers\SystemMgt;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\HolidayMgtService;
use Rap2hpoutre\FastExcel\FastExcel;

class HolidayMgtController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $HolidayMgtService = new HolidayMgtService;
        // 休日情報を取得
        $holidays = $HolidayMgtService->getHolidays();
        return view('system_mgt.holiday_mgt.index')->with([
            'holidays' => $holidays,
        ]);
    }

    public function export()
    {
        // サービスクラスを定義
        $HolidayMgtService = new HolidayMgtService;
        // 休日情報を取得
        $export = $HolidayMgtService->getExportData();
        return (new FastExcel($export))->download('【Touch】休日マスタ_' . new Carbon('now') . '.csv');
    }

    public function import(Request $request)
    {
        // サービスクラスを定義
        $HolidayMgtService = new HolidayMgtService;
        // 選択したファイルをストレージに保存
        $path = $HolidayMgtService->storageImportFile($request);
        // インポート処理
        $HolidayMgtService->import($path);
        return back();
    }
}
