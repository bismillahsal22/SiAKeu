<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tahun_Ajaran;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginAdmin()
    {
        return view('auth.login_admin');
    }

    public function showLoginOperator()
    {
        $tahun_ajaran = Tahun_Ajaran::where('status', 'aktif')
            ->pluck('tahun_ajaran', 'id');
        return view('auth.login_operator', compact('tahun_ajaran'));
    }


    public function showFormLoginWali()
    {
        return view('auth.login_app_wali');
    }

    public function adminLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->akses == 'admin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('login.admin')
                    ->withErrors(['akses' => 'Mohon Maaf, Halaman Ini Bukan Akses Anda!!']);
            }
        }

        return redirect()->route('login.admin')
            ->withErrors(['email' => 'Email atau Password Anda Salah!']);
    }

    public function operatorLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->akses == 'operator') {
                $request->session()->regenerate();
                return redirect()->intended(route('operator.dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('login.operator')
                    ->withErrors(['akses' => 'Mohon Maaf, Halaman Ini Bukan Akses Anda!!']);
            }
        }

        return redirect()->route('login.operator')
            ->withErrors(['email' => 'Email atau Password Anda Salah!']);
    }

    public function waliLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->akses == 'wali') {
                $request->session()->regenerate();
                return redirect()->intended(route('wali.w_dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('login.wali')
                    ->withErrors(['akses' => 'Mohon Maaf, Halaman Ini Bukan Akses Anda!!']);
            }
        }

        return redirect()->route('login.wali')
            ->withErrors(['email' => 'Email atau Password Anda Salah!']);
    }

    // Tambahkan method logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user) {
            switch ($user->akses) {
                case 'wali':
                    return redirect()->route('login.wali');
                case 'admin':
                    return redirect()->route('login.admin');
                case 'operator':
                    return redirect()->route('login.operator');
                default:
                    return redirect('/');
            }
        }

        return redirect('/');
    }
}