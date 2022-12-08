<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\KintaiClose;

class KintaiCloseCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 提出情報を取得する日付を取得（出勤日のパラメータがあればそちらを使用）
        if(isset($request->work_day)){
            $work_day = new Carbon($request->work_day);
            $close_date = $work_day->format('Y-m');
        }else{
            // 現在の日時を取得
            $nowDate = new Carbon('now');
            $close_date = $nowDate->format('Y-m');
        }
        // 勤怠提出情報を取得
        $kintai_close = KintaiClose::where('close_date', $close_date)
                            ->where('base_id', Auth::user()->base_id)
                            ->count();
        // 勤怠提出されているか確認し、提出されていれば直前の画面に戻す
        if($kintai_close == 0){
            return $next($request);
        }else{
            session()->flash('alert_danger', "当月の勤怠が提出されている為、打刻できません。");
            return redirect()->back()->withInput();
        }
    }
}
