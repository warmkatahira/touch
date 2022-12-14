<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpCheck
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
        // IPの配列 * 実際に使う時はDBからデータを取得すると思います
        $ip = [
            ['id' => 1, 'name' => '東京本社', 'ip' => '60.41.201.219'],
            ['id' => 2, 'name' => '大阪支社', 'ip' => '127.0.0.2'],
          ];
        /* 上の変数$ipにアクセスされたIPが含まれているかチェック */
        // $request->ip() で クライアントipが取得できます
        $detect = collect($ip)->contains('ip', $request->ip());
        // ipが含まれていない時の処理
        if (!$detect) {
            // welcomeページへリダイレクト
            return redirect()->route('welcome');
        }
        // ipが含まれていればリクエストが通る
        return $next($request);
    }
}
