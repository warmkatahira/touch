<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStatusCheckMiddleware
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
        // ユーザーステータスが1以外の場合、ログアウトして専用ページへ遷移
        if(Auth::user()->status != 1){
            // ログアウト
            Auth::logout();
            session()->flash('alert_danger', '未承認のユーザーの為、ログインできません。');
            return redirect()->route('welcome');
        }
        return $next($request);
    }
}
