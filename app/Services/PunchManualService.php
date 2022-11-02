<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Kintai;

class PunchManualService
{
    public function getEmployeeBase()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->get();
        return $employees;
    }

    public function checkPunchAvailable($request)
    {
        // 入力された出勤日と従業員の勤怠が存在するか確認
        $kintai = Kintai::where('employee_no', $request->employee)
                        ->where('work_day', $request->work_day)
                        ->first();
        return $kintai;
    }

    public function getEmployee($employee_no)
    {
        // 従業員情報を取得
        $employee = Employee::where('employee_no', $employee_no)->first();
        return $employee;
    }

    public function addKintai($request)
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