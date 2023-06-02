<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CommonService;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        // 拠点情報を取得
        $bases = $CommonService->getBases(false);
        return view('auth.register')->with([
            'bases' => $bases,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'max:20'],
            'user_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 41,
            'base_id' => $request->base,
            'user_name' => $request->user_name,
            'status' => 0,
        ]);

        event(new Registered($user));

        // 自動ログインさせない
        //Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
