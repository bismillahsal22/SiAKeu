<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tahun_Ajaran;
use App\Providers\RouteServiceProvider;
use Auth;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Log;

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
        try {
            // Validasi input
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Ambil kredensial dari input
            $credentials = $request->only('email', 'password');

            // Ambil tahun ajaran yang statusnya aktif, pilih yang pertama
            $tahun_ajaran = Tahun_Ajaran::where('status', 'aktif')->first();

            if (!$tahun_ajaran) {
                Log::error('Tahun ajaran aktif tidak ditemukan.');
                return redirect()->route('login.operator')
                    ->withErrors(['tahun_ajaran' => 'Tahun Ajaran aktif tidak ditemukan!']);
            }

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Mengecek jika user adalah operator
                if ($user->akses == 'operator') {
                    // Cek apakah sebelumnya tahun_ajaran_id null atau tidak
                    if (is_null($user->tahun_ajaran_id)) {
                        Log::info('User belum memiliki tahun ajaran sebelumnya, mengupdate ke tahun ajaran aktif.', [
                            'user_id' => $user->id,
                            'tahun_ajaran_id' => $tahun_ajaran->id,
                        ]);
                    } else {
                        Log::info('User memiliki tahun ajaran sebelumnya, memperbarui tahun ajaran ID.', [
                            'user_id' => $user->id,
                            'old_tahun_ajaran_id' => $user->tahun_ajaran_id,
                            'new_tahun_ajaran_id' => $tahun_ajaran->id,
                        ]);
                    }

                    // Mencoba update tahun_ajaran_id dan menangani kemungkinan error
                    try {
                        $updateSuccess = $user->update([
                            'tahun_ajaran_id' => $tahun_ajaran->id,
                        ]);

                        if (!$updateSuccess) {
                            Log::error('Gagal mengupdate tahun ajaran untuk user ID ' . $user->id);
                            return redirect()->route('operator.dashboard')
                                ->withErrors(['update' => 'Gagal mengupdate data tahun ajaran.']);
                        }
                    } catch (QueryException $e) {
                        // Tangkap jika terjadi error database (misalnya constraint error)
                        Log::error('Error saat mengupdate tahun ajaran: ' . $e->getMessage(), [
                            'user_id' => $user->id,
                            'exception' => $e,
                        ]);
                        return redirect()->route('operator.dashboard')
                            ->withErrors(['update' => 'Terjadi kesalahan saat mengupdate data tahun ajaran.']);
                    }

                    // Memulai sesi baru
                    $request->session()->regenerate();

                    // Redirect ke dashboard operator
                    return redirect()->intended(route('operator.dashboard'));
                } else {
                    Log::warning('User mencoba mengakses halaman operator tanpa akses yang sesuai.', [
                        'user_id' => $user->id,
                        'akses' => $user->akses,
                    ]);
                    Auth::logout();
                    return redirect()->route('login.operator')
                        ->withErrors(['akses' => 'Mohon Maaf, Halaman Ini Bukan Akses Anda!!']);
                }
            }

            Log::error('Login gagal untuk user: ' . $request->email);

            return redirect()->route('login.operator')
                ->withErrors(['email' => 'Email atau Password Anda Salah!']);
        } catch (\Exception $e) {
            Log::error('Error pada operatorLogin: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);
            return redirect()->route('login.operator')
                ->withErrors(['error' => 'Terjadi kesalahan, silakan coba lagi.']);
        }
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