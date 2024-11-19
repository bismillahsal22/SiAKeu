<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\KartuSSoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LaporanKasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\BankSekolahController;
use App\Http\Controllers\ImportSiswaController;
use App\Http\Controllers\LaporanFormController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\ArsipTagihanController;
use App\Http\Controllers\LaporanArsipController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardWaliController;
use App\Http\Controllers\ImportTagihanController;
use App\Http\Controllers\LaporanTagihanController;
use App\Http\Controllers\WaliMuridSiswaController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\TagihanOperatorController;
use App\Http\Controllers\WaliMuridProfilController;
use App\Http\Controllers\WaliMuridInvoiceController;
use App\Http\Controllers\WaliMuridTagihanController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\LaporanPembayaranController;
use App\Http\Controllers\PanduanPembayaranController;
use App\Http\Controllers\KuitansiPembayaranController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UnauthorizedController;
use App\Http\Controllers\WaliMuridPembayaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('landing_page'); //landing_page
});

Route::get('unauthorized', [UnauthorizedController::class, 'index'])->name('unauthorized');
Auth::routes(['verify' => false]);

/* ---------- Route Authentication --------- */
Route::get('login_operator', [LoginController::class, 'showLoginOperator'])->name('login.operator');
Route::get('login_wali', [LoginController::class, 'showFormLoginWali'])->name('login.wali');
Route::get('login_admin', [LoginController::class, 'showLoginAdmin'])->name('login.admin');

Route::post('login_admin', [LoginController::class, 'adminLogin'])->name('postloginadmin');
Route::post('login_operator', [LoginController::class, 'operatorLogin'])->name('postloginoperator');
Route::post('login_wali', [LoginController::class, 'waliLogin'])->name('postloginwali');
/*
|--------------------------------------------------------------------------
| Administrator/Admin
|--------------------------------------------------------------------------
 */
Route::prefix('admin')->middleware(['auth', 'akses:admin'])->group(function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');
    Route::resource('user', UserController::class);
    Route::resource('tahun_ajaran', TahunAjaranController::class); 
    Route::post('tahun_ajaran/{id}/activate', [TahunAjaranController::class, 'activate'])->name('tahun_ajaran.activate');
    Route::post('tahun_ajaran/{id}/deactivate', [TahunAjaranController::class, 'deactivate'])->name('tahun_ajaran.deactivate');
    Route::resource('kelas', KelasController::class); 
    Route::resource('wali', WaliController::class); 
    Route::get('siswa/naik-kelas', [SiswaController::class, 'naikKelas'])->name('siswa.naikKelas');
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('jp', JenisPembayaranController::class );
    Route::get('delete-jp-item/{id}', [JenisPembayaranController::class, 'deleteItem'])->name('delete-jp.item');
    Route::resource('tagihan', TagihanController::class);
    Route::get('get-siswa-details', [TagihanController::class, 'getSiswaDetails'])->name('get.siswa.details');
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('banksekolah', BankSekolahController::class);
    Route::get('kartusso', [KartuSSoController::class, 'index'])->name('kartusso.index');
    Route::get('status/update', [StatusController::class, 'update'])->name('status.update');
    Route::resource('setting', SettingController::class);
    //laporan
    Route::get('laporaform/create', [LaporanFormController::class, 'create'])->name('laporanform.create');
    Route::get('laporan_tag', [LaporanTagihanController::class, 'index'])->name('laporan_tag.index');
    Route::get('laporan_bayar', [LaporanPembayaranController::class, 'index'])->name('laporan_bayar.index');
    //kas
    Route::resource('kas', KasController::class);
    Route::get('pemasukan', [KasController::class, 'pemasukan'])->name('pemasukan.index');
    Route::get('pengeluaran', [KasController::class, 'pengeluaran'])->name('pengeluaran.index');
    Route::get('lap_kas', [LaporanKasController::class, 'index'])->name('lap_kas.index');
    Route::post('importsiswa', ImportSiswaController::class)->name('importsiswa.store');
    Route::post('import_tag', ImportTagihanController::class)->name('import_tag.store');
    Route::resource('arsiptag', ArsipTagihanController::class);
    Route::get('laporan_arsip', [LaporanArsipController::class, 'index'])->name('cetak_arsip.index');
    Route::post('/pembayaran/{id}/gagal', [PembayaranController::class, 'gagalKonfirmasi'])->name('pembayaran.gagal');
});

/*
|--------------------------------------------------------------------------
| Operator
|--------------------------------------------------------------------------
 */
// Route::get('login_operator', [LoginController::class, 'showLoginOperator'])->name('login.operator');
Route::prefix('operator')->middleware(['auth', 'akses:operator'])->name('operator.')->group(function(){
    Route::middleware(['auth', 'tahun.ajaran'])->group(function () {
        Route::get('dashboard', [DashboardOperatorController::class, 'index'])->name('dashboard');
        Route::resource('tagihan', TagihanOperatorController::class);
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('transaksi/show', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('pembayaran/{tagihan}', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/store', [TransaksiController::class, 'store'])->name('pembayaran.store');
    });
    
});

/*
|--------------------------------------------------------------------------
| Wali Siswa
|--------------------------------------------------------------------------
 */
//login wali
Route::get('register_wali', [RegisterController::class, 'showFormRegisterWali'])->name('register.wali.show');
Route::post('/register/wali', [RegisterController::class, 'registerWali'])->name('register.wali');
Route::get('lp_wali', [HomeController::class, 'showLandingPageWali'])->name('lp.wali');
Route::get('login_wali', [LoginController::class, 'showFormLoginWali'])->name('login.wali');

Route::prefix('wali_siswa')->middleware(['auth', 'akses:wali'])->name('wali.')->group(function(){
    Route::get('w_dashboard', [DashboardWaliController::class, 'index'])->name('w_dashboard');
    Route::resource('siswa', WaliMuridSiswaController::class);
    Route::resource('tagihan', WaliMuridTagihanController::class);
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
    Route::resource('profil', WaliMuridProfilController::class);
    
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
 */
Route::get('logout', function() {
    $user = Auth::user(); // Ambil pengguna yang sedang login
    Auth::logout();
    if ($user) {
        if ($user->akses === 'wali') {
            return redirect()->route('login.wali'); // Rute login wali siswa
        } elseif ($user->akses === 'admin') {
            return redirect()->route('login.admin'); // Rute login admin
        } elseif ($user->akses === 'operator') {
            return redirect()->route('login.operator'); // Rute login operator
        }
    }
})->name('logout.manual');

// Mengolah reset password
Route::post('password/reset/direct', [ForgotPasswordController::class, 'resetDirect'])->name('password.reset.direct');

Route::get('panduan-pembayaran/{id}', [PanduanPembayaranController::class, 'index'])->name('panduan.pembayaran');
Route::get('kuitansi_pembayaran/{id}', [KuitansiPembayaranController::class, 'show'])->name('kuitansipembayaran.show');
Route::resource('invoice', WaliMuridInvoiceController::class);
Route::get('/siswa/{id}', [SiswaController::class, 'getSiswa'])->name('siswa.get');