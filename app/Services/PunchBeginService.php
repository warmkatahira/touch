<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Kintai;
use App\Models\KintaiDetail;

class PunchBeginService
{
    // 出勤タイプを変更するボタンの表示を管理
    public function getBeginTypeBtnDisp()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 現在の時刻が8時台より前であればon(表示)、9時台以降であればoff(非表示)
        $punch_begin_type_btn_disp = $nowDate->hour <= 8 ? 'on' : 'off';
        return $punch_begin_type_btn_disp;
    }

    // 早出ができる状態の時、直近4時間分の情報を取得（15分刻みで）
    public function getEarlyWorkSelectInfo($punch_begin_type_btn_disp)
    {
        // 変数をセット
        $early_work_select_info = [];
        // onの時のみ取得
        if($punch_begin_type_btn_disp == 'on'){
            // 現在の日時を取得
            $nowDate = new Carbon('now');
            // 15分単位で切り上げ
            $nowDate = $nowDate->addMinutes(15 - $nowDate->minute % 15);
            // 処理を4回実施
            for($i = 0; $i < 4; $i++){
                // 時刻部分だけの情報を格納（H:mm）
                $early_work_select_info[] = $nowDate->toTimeString('minute');
                $nowDate = new Carbon($nowDate);
                $nowDate = $nowDate->addMinutes(15);
            }
        }
        return $early_work_select_info;
    }

    // 出勤打刻対象者を取得
    public function getPunchBeginTargetEmployee()
    {
        // 出勤打刻対象者を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->doesntHave('punch_begin_targets')
                        ->orderBy('employee_no')
                        ->get();
        return $employees;
    }

    // 勤怠テーブルに追加
    public function addKintai($request)
    {
        // 早出フラグを取得(リクエストパラメータがある = 早出となる) ※早出は1
        $is_early_worked = isset($request->punch_begin_type) ? 1 : 0;
        // 早出かどうかで取得する日時を可変
        if($is_early_worked == 0){
            // 現在の日時を取得
            $nowDate = new Carbon('now');
        }
        if($is_early_worked == 1){
            $nowDate = new Carbon($request->early_work_select_info);
        }
        // 出勤時間調整を算出・取得
        $begin_time_adj = $this->getBeginTimeAdj($nowDate, $is_early_worked);
        // レコードを追加
        $kintai = Kintai::create([
            'kintai_id' => $request->punch_key.'-'.$nowDate->format('Ymd'),
            'employee_no' => $request->punch_key,
            'work_day' => $nowDate->format('Ymd'),
            'begin_time' => $nowDate->format('H:i:00'), // 秒は00に調整している
            'begin_time_adj' => $begin_time_adj,
            'is_early_worked' => $is_early_worked,
        ]);
        return $kintai;
    }

    // 出勤時間調整を算出・取得
    public function getBeginTimeAdj($Date, $is_early_worked)
    {
        // 現在の日時をインスタンス化
        $begin_time_adj = new Carbon($Date);
        // 9時前かつ早出ではない($is_early_worked = 0)場合、09:00:00に調整する
        if($begin_time_adj->format('H:i:00') <= "09:00:00" && $is_early_worked == 0){
            $begin_time_adj = "09:00:00";
        }else{
            // 15分単位で切り上げ
            $begin_time_adj = $begin_time_adj->addMinutes(15 - $begin_time_adj->minute % 15);
            $begin_time_adj = $begin_time_adj->format('H:i:00');
        }
        return $begin_time_adj;
    }
}