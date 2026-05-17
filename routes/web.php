<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\TagihanController;
use App\Http\Controllers\Mahasiswa\PembayaranController;
use App\Http\Controllers\Mahasiswa\RiwayatController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;
use App\Http\Controllers\AdminKeuangan\DashboardController as AdminKeuanganDashboard;
use App\Http\Controllers\Akademik\DashboardController as AkademikDashboard;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return match ($user->role) {
            'mahasiswa' => redirect()->route('dashboard.mahasiswa'),
            'admin_keuangan', 'admin' => redirect()->route('dashboard.admin.keuangan'),
            'akademik' => redirect()->route('dashboard.akademik'),
            'pimpinan' => redirect()->route('dashboard.pimpinan'),
            default => redirect('/login'),
        };
    }
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

// Disable public registration for internal SIPATU users
Route::get('/register', function () {
    abort(404);
})->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'mahasiswa' => redirect()->route('dashboard.mahasiswa'),
        'admin' => redirect()->route('dashboard.admin.keuangan'),
        'akademik' => redirect()->route('dashboard.akademik'),
        'pimpinan' => redirect()->route('dashboard.pimpinan'),
        default => redirect('/login'),
    };
})->middleware('auth')->name('dashboard.home');

// ==================== MAHASISWA ROUTES ====================
Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/', [MahasiswaDashboard::class, 'index'])->name('dashboard.mahasiswa');
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('dashboard.mahasiswa.tagihan');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('dashboard.mahasiswa.pembayaran');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('dashboard.mahasiswa.riwayat');
    Route::get('/riwayat/export-pdf', [RiwayatController::class, 'exportPdf'])->name('dashboard.mahasiswa.riwayat.export');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('dashboard.mahasiswa.notifikasi');
    Route::get('/tagihan/{tagihan}/bayar', [PembayaranController::class, 'showPaymentForm'])->name('dashboard.mahasiswa.payment.form');
    Route::post('/tagihan/{tagihan}/bayar', [PembayaranController::class, 'storePayment'])->name('dashboard.mahasiswa.payment.process');
    Route::post('/notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('dashboard.mahasiswa.notifikasi.read');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllRead'])->name('dashboard.mahasiswa.notifikasi.readAll');
});

// ==================== ADMIN KEUANGAN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'role:admin_keuangan'])->group(function () {
    Route::get('/', [AdminKeuanganDashboard::class, 'index'])->name('dashboard.admin.keuangan');
    Route::get('/payments', [AdminKeuanganDashboard::class, 'payments'])->name('dashboard.admin.keuangan.payments');
    Route::get('/payments/{pembayaran}/verify', [AdminKeuanganDashboard::class, 'verify'])->name('dashboard.admin.keuangan.verify');
    Route::post('/payments/{pembayaran}/verify', [AdminKeuanganDashboard::class, 'processVerification'])->name('dashboard.admin.keuangan.verify.process');
    Route::get('/tagihans', [AdminKeuanganDashboard::class, 'tagihans'])->name('dashboard.admin.keuangan.tagihans');
    Route::get('/tagihans/create', [AdminKeuanganDashboard::class, 'createTagihan'])->name('dashboard.admin.keuangan.tagihan.create');
    Route::post('/tagihans/create', [AdminKeuanganDashboard::class, 'storeTagihan'])->name('dashboard.admin.keuangan.tagihan.store');
    Route::post('/tagihans/{tagihan}/remind', [AdminKeuanganDashboard::class, 'sendReminder'])->name('dashboard.admin.keuangan.tagihan.remind');
    Route::get('/laporan', [AdminKeuanganDashboard::class, 'laporan'])->name('dashboard.admin.keuangan.laporan');
});

// ==================== AKADEMIK ROUTES ====================
Route::prefix('akademik')->middleware(['auth', 'role:akademik'])->group(function () {
    Route::get('/', [AkademikDashboard::class, 'index'])->name('dashboard.akademik');
    Route::get('/mahasiswas', [AkademikDashboard::class, 'mahasiswas'])->name('dashboard.akademik.mahasiswas');
    Route::get('/tagihan', [AkademikDashboard::class, 'tagihan'])->name('dashboard.akademik.tagihan');
    Route::get('/mahasiswas/create', [AkademikDashboard::class, 'createMahasiswa'])->name('dashboard.akademik.mahasiswa.create');
    Route::post('/mahasiswas/create', [AkademikDashboard::class, 'storeMahasiswa'])->name('dashboard.akademik.mahasiswa.store');
    Route::get('/mahasiswas/{mahasiswa}/edit', [AkademikDashboard::class, 'editMahasiswa'])->name('dashboard.akademik.mahasiswa.edit');
    Route::put('/mahasiswas/{mahasiswa}/edit', [AkademikDashboard::class, 'updateMahasiswa'])->name('dashboard.akademik.mahasiswa.update');
    Route::delete('/mahasiswas/{mahasiswa}', [AkademikDashboard::class, 'destroyMahasiswa'])->name('dashboard.akademik.mahasiswa.destroy');
    Route::get('/mahasiswas/{mahasiswa}', [AkademikDashboard::class, 'showMahasiswa'])->name('dashboard.akademik.show-mahasiswa');
    Route::get('/mahasiswas/{mahasiswa}/tagihan/create', [AkademikDashboard::class, 'createTagihan'])->name('dashboard.akademik.mahasiswa.tagihan.create');
    Route::post('/mahasiswas/{mahasiswa}/tagihan/create', [AkademikDashboard::class, 'storeTagihan'])->name('dashboard.akademik.mahasiswa.tagihan.store');
    Route::post('/tagihan/{tagihan}/remind', [AkademikDashboard::class, 'sendReminder'])->name('dashboard.akademik.tagihan.remind');
});

// ==================== PIMPINAN ROUTES ====================
Route::prefix('pimpinan')->middleware(['auth', 'role:pimpinan'])->group(function () {
    Route::get('/', [PimpinanDashboard::class, 'index'])->name('dashboard.pimpinan');
    Route::get('/laporan', [PimpinanDashboard::class, 'laporan'])->name('dashboard.pimpinan.laporan');
    Route::get('/rekap-tagihan', [PimpinanDashboard::class, 'rekapTagihan'])->name('dashboard.pimpinan.rekap-tagihan');
    Route::get('/monitoring', [PimpinanDashboard::class, 'monitoring'])->name('dashboard.pimpinan.monitoring');
    Route::get('/laporan/export-pdf', [PimpinanDashboard::class, 'exportPdf'])->name('dashboard.pimpinan.export-pdf');
    Route::get('/laporan/export-excel', [PimpinanDashboard::class, 'exportExcel'])->name('dashboard.pimpinan.export-excel');
});

// Fallback dashboard route (redirects based on role)
Route::get('/sipatu/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'mahasiswa' => redirect()->route('dashboard.mahasiswa'),
        'admin_keuangan', 'admin' => redirect()->route('dashboard.admin.keuangan'),
        'akademik' => redirect()->route('dashboard.akademik'),
        'pimpinan' => redirect()->route('dashboard.pimpinan'),
        default => redirect('/login'),
    };
})->middleware('auth')->name('dashboard');

Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'mahasiswa' => redirect()->route('dashboard.mahasiswa'),
        'admin_keuangan', 'admin' => redirect()->route('dashboard.admin.keuangan'),
        'akademik' => redirect()->route('dashboard.akademik'),
        'pimpinan' => redirect()->route('dashboard.pimpinan'),
        default => redirect('/login'),
    };
})->middleware('auth');
