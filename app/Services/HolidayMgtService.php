<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Holiday;
use Rap2hpoutre\FastExcel\FastExcel;

class HolidayMgtService
{
    public function getHolidays()
    {
        // 休日テーブルの情報を全て取得
        $holidays = Holiday::all();
        return $holidays;
    }

    public function getExportData()
    {
        // 出力する情報を取得
        $export = Holiday::select(
            DB::raw(
                'holiday as 休日,
                holiday_note as 備考'
            ))->get();
        return $export;
    }

    public function storageImportFile($request)
    {
        // 選択したファイルをストレージに保存
        $select_file = $request->file('holiday_csv');
        $uploaded_file = $select_file->getClientOriginalName();
        $orgName = 'holiday.csv';
        $spath = storage_path('app/');
        $path = $spath.$select_file->storeAs('public/import',$orgName);
        return $path;
    }

    public function import($path)
    {
        // テーブルをクリア
        Holiday::query()->delete();
        // データを取得
        $lines = (new FastExcel)->import($path);
        // データの行数分だけループ
        foreach ($lines as $index => $line) {
            // UTF-8形式に変換（日本語文字化け対策）
            $line = mb_convert_encoding($line, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
            // レコードを追加
            Holiday::create([
                'holiday' => $line['休日'],
                'holiday_note' => $line['備考'],
            ]);
        }
    }
}