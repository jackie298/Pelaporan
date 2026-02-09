<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store(Request $request)
    {
        // Validasi input
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah checkbox "Remember Me" dicentang
        $remember = $request->boolean('rememberMe');

        // Proses autentikasi dengan remember me
        if (Auth::attempt($attributes, $remember)) {
            $request->session()->regenerate();
            return redirect('dashboard')->with(['success' => 'You are logged in.']);
        } else {
            return back()->withErrors(['email' => 'Email or password invalid.'])
                         ->withInput($request->only('email', 'rememberMe'));
        }
    }
    
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with(['success' => 'You\'ve been logged out.']);
    }
}