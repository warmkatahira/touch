<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kintai;
use App\Models\KintaiDetail;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Services\PunchModifyService;
use App\Services\PunchBeginService;
use App\Services\PunchFinishInputService;
use App\Http\Requests\KintaiModifyRequest;

class KintaiModifyController extends Controller
{
    public function index(Request $request)
    {
        // 勤怠IDをセッションに格納
        session(['kintai_id' => $request->kintai_id]);
        // 勤怠情報を取得
        $kintai = Kintai::where('kintai_id', $request->kintai_id)->first();
        return view('kintai_modify.index')->with([
            'kintai' => $kintai,
        ]);
    }

    // 出退勤・外出戻り時間をバリデーションしている
    public function input(KintaiModifyRequest $request)
    {
        // サービスクラスを定義
        $PunchModifyService = new PunchModifyService;
        // 外出戻り関連の時間を取得
        $out_return_time = $PunchModifyService->getOutReturnTime($request);
        dd($out_return_time);
        // 勤怠情報を取得
        $kintai = Kintai::where('kintai_id', session('kintai_id'))->first();
        $kintai_details = KintaiDetail::where('kintai_id', session('kintai_id'))->get();
        // 自拠点の荷主情報を取得
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $customer_groups = CustomerGroup::all();
        return view('kintai_modify.input')->with([
            'kintai' => $kintai,
            'kintai_details' => $kintai_details,
            'customers' => $customers,
            'customer_groups' => $customer_groups,
        ]);
    }
}
