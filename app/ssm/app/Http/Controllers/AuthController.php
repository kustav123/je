<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        return view('admin.auth.login');

    }

    function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',

        ]);



        $credentials = [
            'username' => $request->email,
            'password' => $request->password,
            // 'role' => $request->userType
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $request->user()->update([
                'lastlogin_from' => $request->getClientIp()
            ]);
            return redirect()->intended('/');


        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    function logout(Request $request)
    {
        // Auth::guard('web')->logout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
