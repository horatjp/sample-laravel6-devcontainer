<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{

    protected function guard()
    {
        return Auth::guard('manager');
    }

    public function getLogin()
    {

        if (Auth::check()) {
            return redirect()->route('backend.index');
        }

        return view('backend.auth.login');
    }

    public function postLogin()
    {
        $rules = [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ];
        $attribute = ['email' => 'メールアドレス', 'password' => 'パスワード'];

        request()->validate($rules, [], $attribute);


        $credentials = [
            'email' => request()->input('email'),
            'password' => request()->input('password'),
            'active'   => 1,
        ];

        if (Auth::attempt($credentials, request()->has('remember'))) {
            return redirect()->route('backend.index');
        }


        return redirect()->route('backend.login')
            ->withInput(request()->only('email', 'remember'))
            ->withErrors(['login' => ['メールアドレス／パスワードが無効です。']]);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('backend.login');
    }
}
