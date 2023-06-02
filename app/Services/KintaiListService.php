<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Models\Employee;
use App\Models\Base;
use App\Models\Customer;
use App\Models\EmployeeCategory;
use App\Models\Tag;
use App\Models\KintaiTag;

class KintaiListService
{
    public function deleteSearchSession()
    {
        // セッションを削除
        session()->forget(['search_target', 'search_manager_checked', 'search_tag', 'search_employee_name', 'search_base', 'search_employee_category', 'search_work_day_from', 'search_work_day_to']);
        return;
    }

    public function setDefaultCondition()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 初期条件をセット
        session(['search_target' => 'all_target']);
        session(['search_manager_checked' => 'all_manager_checked']);
        session(['search_tag' => 'all_tag']);
        session(['search_base' => Auth::user()->base_id]);
        session(['search_work_day_from' => $nowDate->toDateString()]);
        session(['search_work_day_to' => $nowDate->toDateString()]);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['search_target' => $request->search_target]);
        session(['search_manager_checked' => $request->search_manager_checked]);
        session(['search_tag' => $request->search_tag]);
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

    public function getKintaiSearch($error_info)
    {
        // エラーがなければ、検索処理を実施
        if(is_null($error_info)){
            // エラーアラートを削除
            session()->forget('alert_danger');
            // 現在のURLを取得
            session(['back_url_1' => url()->full()]);
            // テーブルを結合して、出勤日の条件を適用
            $kintai_tags = KintaiTag::join('kintais', 'kintais.kintai_id', 'kintai_tags.kintai_id')
                            ->whereBetween('work_day', [session('search_work_day_from'), session('search_work_day_to')]);
            // タグ数をカウント
            $kintai_tags = $kintai_tags->select(DB::raw("count(kintais.kintai_id) as tag_count, kintais.kintai_id"));
            // グループ化
            $kintai_tags = $kintai_tags->groupBy('kintais.kintai_id');
            // テーブルを結合して、タグ数を集計したクエリを結合
            $kintais = Employee::join('kintais', 'kintais.employee_no', 'employees.employee_no')
                        ->whereBetween('work_day', [session('search_work_day_from'), session('search_work_day_to')])
                        ->leftJoinSub($kintai_tags, 'KINTAITAGS', function ($join) {
                            $join->on('kintais.kintai_id', '=', 'KINTAITAGS.kintai_id');
                        })
                        ->select('kintais.*', 'employees.*', 'KINTAITAGS.tag_count');
            // 対象条件で抽出（全ての場合は何もしなくて良いので、未退勤のみの場合に条件を適用）
            if (session('search_target') == 'no_finish') {
                $kintais->whereNull('finish_time');
            }
            // 管理者確認条件で抽出（全ての場合は何もしなくて良いので、それ以外の場合に条件を適用）
            if (session('search_manager_checked') != 'all_manager_checked') {
                // 未確認
                if (session('search_manager_checked') == 'unconfirmed') {
                    $kintais->whereNull('manager_checked_at');
                }
                // 確認済み
                if (session('search_manager_checked') == 'confirmed') {
                    $kintais->whereNotNull('manager_checked_at');
                }
            }
            // タグ条件で抽出（全ての場合は何もしなくて良いので、それ以外の場合に条件を適用）
            if (session('search_tag') != 'all_tag') {
                // 無し
                if (session('search_tag') == 'no_tag') {
                    $kintais->whereNull('tag_count');
                }
                // 有り
                if (session('search_tag') == 'on_tag') {
                    $kintais->whereNotNull('tag_count');
                }
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
            $kintais = $kintais->orderBy('work_day')->orderBy('employees.employee_no')->paginate(50);
        }
        // エラーがあればメッセージを表示
        if(!is_null($error_info)){
            $kintais = array();
            session()->flash('alert_danger', $error_info);
        }
        return $kintais;
    }

    public function getKintai($kintai_id)
    {
        // 勤怠IDで対象の勤怠を取得
        $kintai = Kintai::where('kintai_id', $kintai_id)->first();
        // 荷主マスタと拠点マスタをユニオン
        $subquery = Customer::select('customer_id', 'customer_name')
                ->union(Base::select('base_id', 'base_name'));
        // 勤怠詳細テーブルと荷主・拠点情報を結合
        $kintai_details = KintaiDetail::where('kintai_id', $kintai_id)
                        ->join(DB::raw("({$subquery->toSql()}) as temp"), function($join) {
                            $join->on('kintai_details.customer_id', '=', 'temp.customer_id');
                        })
                        ->select('temp.customer_name', 'kintai_details.customer_working_time')
                        ->orderBy('kintai_details.customer_working_time', 'desc')
                        ->get();
        // 勤怠に紐付いているタグ情報を取得
        $kintai_tags = KintaiTag::where('kintai_id', $kintai_id)->get();
        return compact('kintai', 'kintai_details', 'kintai_tags');
    }

    public function getTag()
    {
        // タグ情報を取得(ロールに合わせて変動)
        $tags = Tag::where('owner_role_id', Auth::user()->role_id)->get();
        return $tags;
    }
}