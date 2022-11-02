<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\KintaiDetail;

class KintaiCommonService
{
    // 勤怠情報を取得
    public function getKintai($kintai_id)
    {
        // 勤怠情報を取得
        $kintai = Kintai::where('kintai_id', $kintai_id)->first();
        $kintai_details = KintaiDetail::where('kintai_id', $kintai_id)->get();
        // 従業員情報を取得
        $employee = $kintai->employee;
        return compact('kintai', 'kintai_details', 'employee');
    }
}