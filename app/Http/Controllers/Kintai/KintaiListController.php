<?php

namespace App\Http\Controllers\Kintai;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Services\KintaiListService;
use App\Services\PunchFinishInputService;
use Carbon\Carbon;
use App\Services\CommonService;

class KintaiListController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $KintaiListService = new KintaiListService;
        $CommonService = new CommonService;
        // 検索条件が格納されているセッションをクリア
        $KintaiListService->deleteSearchSession();
        // 初期条件をセット
        $KintaiListService->setDefaultCondition(); 
        // 検索条件と一致した勤怠を取得
        $kintais = $KintaiListService->getKintaiSearch(null);
        // 従業員区分情報を取得
        $employee_categories = $CommonService->getEmployeeCategories();
        // 拠点情報を取得
        $bases = $CommonService->getBases(true, false);
        return view('kintai_list.index')->with([
            'kintais' => $kintais,
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $KintaiListService = new KintaiListService;
        $CommonService = new CommonService;
        // 検索条件が格納されているセッションをクリア
        $KintaiListService->deleteSearchSession();
        // 検索条件をセッションに格納
        $KintaiListService->getSearchCondition($request);
        // 出勤日の条件が正しいか確認
        $error_info = $KintaiListService->checkWorkdayCondition();
        // 指定された条件の勤怠を取得
        $kintais = $KintaiListService->getKintaiSearch($error_info);
        // 従業員区分情報を取得
        $employee_categories = $CommonService->getEmployeeCategories();
        // 拠点情報を取得
        $bases = $CommonService->getBases(true, false);
        return view('kintai_list.index')->with([
            'kintais' => $kintais,
            'bases' => $bases,
            'employee_categories' => $employee_categories,
        ]);
    }

    public function detail(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // サービスクラスを定義
        $KintaiListService = new KintaiListService;
        $PunchFinishInputService = new PunchFinishInputService;
        // 勤怠情報を取得
        $kintai = $KintaiListService->getKintai($request->kintai_id);
        // タグ情報を取得
        $tags = $KintaiListService->getTag();
        // 追加休憩取得時間を表示させるか判定
        $add_rest_time_disp = $PunchFinishInputService->getAddRestTimeDisp();
        return view('kintai_list.detail')->with([
            'kintai' => $kintai['kintai'],
            'kintai_details' => $kintai['kintai_details'],
            'kintai_tags' => $kintai['kintai_tags'],
            'tags' => $tags,
            'add_rest_time_disp' => $add_rest_time_disp,
        ]);
    }

    public function manager_check(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 勤怠IDを指定して拠点管理者確認日時を更新
        foreach($request->chk as $kintai_id){
            Kintai::where('kintai_id', $kintai_id)->update([
                'manager_checked_at' => $nowDate,
            ]);
        }
        return back();
    }
}
