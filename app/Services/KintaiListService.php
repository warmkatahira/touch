<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Base;
use App\Models\EmployeeCategory;

class KintaiListService
{
    public function deleteSearchSession()
    {
        // セッションを削除
        session()->forget(['search_target', 'search_employee_name', 'search_base', 'search_employee_category', 'search_work_day_from', 'search_work_day_to']);
        return;
    }

    public function setDefaultCondition()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 初期条件をセット
        session(['search_target' => 'all']);
        session(['search_base' => Auth::user()->base_id]);
        session(['search_work_day_from' => $nowDate->toDateString()]);
        session(['search_work_day_to' => $nowDate->toDateString()]);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['search_target' => $request->search_target]);
        session(['search_employee_name' => $request->search_employee_name]);
        session(['search_base' => $request->search_base]);
        session(['search_employee_category' => $request->search_employee_category]);
        session(['search_work_day_from' => $request->search_work_day_from]);
        session(['search_work_day_to' => $request->search_work_day_to]);
        return;
    }

    public function checkWorkdayCondition()
    {
        // エラー内容を格納する変数をセット
        $error_info = null;
        // 出勤日の条件が正しいかチェック
        // 条件1:開始と終了の日付がどちらも指定されているか
        // 条件2:開始と終了の期間が60日以内であるか
        if (!empty(session('search_work_day_from')) && !empty(session('search_work_day_to'))) {
            // 開始と終了の日にちの差を取得
            $from = new Carbon(session('search_work_day_from'));
            $to = new Carbon(session('search_work_day_to'));
            $diff_days_from_to = $from->diffInDays($to);
            // 日にちの差が60日より大きければNG
            if($diff_days_from_to > 60){
                $error_info = "出勤日の範囲が大き過ぎます。\n60日以内になるように指定して下さい。";
            }
        }else{
            $error_info = '出勤日の指定は必須です。';
        }
        return $error_info;
    }

    public function getKintaiSearch()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // テーブルを結合して、出勤日の条件を適用
        $kintais = Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                    ->whereBetween('work_day', [session('search_work_day_from'), session('search_work_day_to')]);
        // 対象条件で抽出（全ての場合は何もしなくて良いので、未退勤のみの場合に条件を適用）
        if (session('search_target') == 'no_finish') {
            $kintais->whereNull('finish_time');
        }
        // 氏名条件がある場合
        if (!empty(session('search_employee_name'))) {
            $kintais->where('employee_name', 'LIKE', '%'.session('search_employee_name').'%');
        }
        // 営業所条件がある場合
        if (!empty(session('search_base'))) {
            $kintais->where('base_id', session('search_base'));
        }
        // 区分条件がある場合
        if (!empty(session('search_employee_category'))) {
            $kintais->where('employee_category_id', session('search_employee_category'));
        }
        // 出勤日と従業員番号で並び替え
        $kintais = $kintais->orderBy('work_day')->orderBy('employees.employee_no')->get();
        return $kintais;
    }

    public function getPulldownInfo()
    {
        // 拠点と従業員区分を取得
        $bases = Base::all();
        $employee_categories = EmployeeCategory::all();
        return compact('bases', 'employee_categories');
    }
}