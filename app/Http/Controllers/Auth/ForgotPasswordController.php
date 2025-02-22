<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    public function resetDirect(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
    
            // Mengecek apakah user adalah admin atau bukan
            if ($user->akses === 'admin') {
                // Redirect ke halaman login admin jika role user adalah admin
                return redirect()->route('login.admin')->with('success', 'Password berhasil direset.');
            } else {
                // Redirect ke halaman login pengguna biasa jika role user bukan admin
                return redirect()->route('login.wali')->with('success', 'Password berhasil direset.');
            }
        }
    
        // Jika user tidak ditemukan
        return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }
}