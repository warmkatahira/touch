<?php

namespace App\Services\ManagementFunc;

use Illuminate\Support\Facades\DB;
use App\Models\Base;
use App\Models\KintaiClose;
use Carbon\CarbonImmutable;

class KintaiCloseCheckService
{
    public function setDefaultCondition()
    {
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // 初期条件をセット
        session(['search_month' => $nowDate->format('Y-m')]);
        return;
    }

    public function getSearchCondition($search_month)
    {
        // 検索条件をセット
        session(['search_month' => $search_month]);
        return;
    }

    public function getKintaiCloseSearch()
    {
        // 指定された年月かつ自拠点勤怠の提出情報を取得
        $kintai_closes = KintaiClose::where('close_date', session('search_month'));
        // 集計した勤怠を従業員テーブルと結合
        $kintai_closes = Base::where('bases.base_id', '!=', 'system_common')
            ->leftJoinSub($kintai_closes, 'KINTAIS', function ($join) {
                $join->on('bases.base_id', '=', 'KINTAIS.base_id');
            })
            ->select('bases.base_id', 'bases.base_name', 'KINTAIS.updated_at', DB::raw("'".session('search_month')."' as close_date"))
            ->orderBy('bases.base_id', 'asc')
            ->get();
        return $kintai_closes;
    }
}