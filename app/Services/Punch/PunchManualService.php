<?php

namespace App\Services\Punch;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Kintai;

class PunchManualService
{
    public function checkPunchAvailable($request)
    {
        // 入力された出勤日と従業員の勤怠が存在するか確認
        return Kintai::where('employee_no', $request->employee)
                        ->where('work_day', $request->work_day)
                        ->first();
    }

    public function createKintai($request)
    {
        // 早出フラグを取得(リクエストパラメータがある = 早出となる) ※早出は1
        $is_early_worked = is_null(session('punch_begin_type')) ? 0 : 1;
        // レコードを追加
        $kintai = Kintai::create([
            'kintai_id' => $request->employee_no.'-'.$request->work_day,
            'employee_no' => $request->employee_no,
            'work_day' => $request->work_day,
            'begin_time' => session('begin_time'),
            'begin_time_adj' => session('begin_time_adj'),
            'finish_time' => session('finish_time'),
            'finish_time_adj' => session('finish_time_adj'),
            'out_time' => session('out_time'),
            'out_time_adj' => session('out_time_adj'),
            'return_time' => session('return_time'),
            'return_time_adj' => session('return_time_adj'),
            'out_return_time' => session('out_return_time'),
            'is_early_worked' => $is_early_worked,
            'rest_time' => $request->rest_time,
            'no_rest_time' => $request->no_rest_time,
            'add_rest_time' => isset($request->add_rest_time) ? $request->add_rest_time : 0,
            'working_time' => $request->working_time * 60,
            'is_early_worked' => $is_early_worked,
            'is_manual_punched' => 1,
        ]);
        return $kintai;
    }

    public function updateOverTime($kintai_id, $over_time)
    {
        // 残業時間を更新
        Kintai::where('kintai_id', $kintai_id)->update([
            'over_time' => $over_time * 60,
        ]);
        return;
    }
}