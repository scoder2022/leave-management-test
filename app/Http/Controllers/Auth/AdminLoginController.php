<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return redirect()->back()->with('error', 'Login Error. Invalid Access.');
            }
            return redirect('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Wrong email or password. Try again or click Forgot password to reset it..');
    }
}
