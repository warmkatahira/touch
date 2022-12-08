<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kintai;

class KintaiOperationCheck
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
        // 勤怠を取得
        $kintai = Kintai::where('kintai_id', $request->kintai_id)->first();
        // 経理ロール以上又は拠点管理者ロールの場合は自拠点の勤怠であれば(拠点管理者はロックがかかっていない場合のみ)
        if(Auth::user()->role_id <= 11 || Auth::user()->role_id == 31 && Auth::user()->base_id == $kintai->employee->base_id && is_null($kintai->locked_at)){
            return $next($request);
        }else{
            session()->flash('alert_danger', "権限がありません。");
            return back();
        }
    }
}
