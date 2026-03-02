<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        // Jika user sudah login, arahkan langsung ke dashboard
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

        return view('session.login-session');
    }

    public function store(Request $request)
    {
        // 1. Validasi dengan pesan custom (opsional)
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Ambil nilai remember me
        $remember = $request->filled('rememberMe');

        // 3. Proses Autentikasi
        // Menggunakan intended() untuk mengembalikan user ke halaman yang mereka tuju sebelumnya
        if (Auth::attempt($credentials, $remember)) {
            
            // Proteksi Session Fixation
            $request->session()->regenerate();

            return redirect()->intended('dashboard')
                             ->with('success', 'Selamat datang kembali!');
        }

        // 4. Gagalkan login dengan cara yang lebih Laravel-way
        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // Menggunakan file bahasa bawaan Laravel
        ]);
    }
    
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with(['success' => 'You\'ve been logged out.']);
    }
}