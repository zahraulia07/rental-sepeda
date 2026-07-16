<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SepedaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminMaintenanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\NotificationController;

// Jalur Autentikasi (hanya untuk tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Halaman utama: arahkan sesuai role masing-masing
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    return redirect(auth()->user()->role === 'admin' ? '/admin/sepeda' : '/dashboard');
})->middleware('auth');

// Notifikasi: dipakai admin MAUPUN user, jadi ditaruh terpisah dari grup role:admin / role:user
Route::middleware('auth')->group(function () {
    Route::post('/notifikasi/tandai-dibaca', [NotificationController::class, 'tandaiDibaca']);
    Route::get('/notifikasi/{id}/buka', [NotificationController::class, 'bukaTransaksi']);
});

// Dashboard Admin (khusus role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Inventaris sepeda
    Route::get('/sepeda', [SepedaController::class, 'index']);
    Route::post('/sepeda', [SepedaController::class, 'store']);
    Route::put('/sepeda/{id}', [SepedaController::class, 'update']);
    Route::delete('/sepeda/{id}', [SepedaController::class, 'destroy']);

    // Manajemen transaksi (approval, ambil, kembalikan)
    Route::get('/transaksi', [AdminTransaksiController::class, 'index']);
    Route::post('/transaksi/{id}/setujui', [AdminTransaksiController::class, 'setujui']);
    Route::post('/transaksi/{id}/tolak', [AdminTransaksiController::class, 'tolak']);
    Route::post('/transaksi/{id}/ambil', [AdminTransaksiController::class, 'ambil']);
    Route::post('/transaksi/{id}/kembalikan', [AdminTransaksiController::class, 'kembalikan']);

    // Riwayat transaksi selesai
    Route::get('/riwayat', [AdminTransaksiController::class, 'riwayat']);

    // Manajemen pelanggan & blacklist
    Route::get('/pelanggan', [AdminPelangganController::class, 'index']);
    Route::post('/pelanggan/{id}/blokir', [AdminPelangganController::class, 'blokir']);
    Route::post('/pelanggan/{id}/buka-blokir', [AdminPelangganController::class, 'bukaBlokir']);

    // Laporan & rekap pendapatan
    Route::get('/laporan', [AdminLaporanController::class, 'index']);

    // Log maintenance sepeda
    Route::get('/maintenance', [AdminMaintenanceController::class, 'index']);
    Route::post('/maintenance', [AdminMaintenanceController::class, 'store']);
    Route::post('/maintenance/{id}/selesai', [AdminMaintenanceController::class, 'selesai']);
});

// Dashboard User: katalog sepeda & fitur sewa (khusus role user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [RentalController::class, 'index']);
    Route::post('/sewa/{id}', [RentalController::class, 'sewa']);
    Route::post('/pembayaran/{id}/konfirmasi', [RentalController::class, 'konfirmasiPembayaran']);

    // Nota digital / kuitansi untuk transaksi yang sudah selesai
    Route::get('/riwayat/{id}/nota', [RentalController::class, 'nota']);

    // Profil akun: edit data diri & ganti password
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

    // Informasi: syarat & ketentuan, panduan cara menyewa, tentang kami
    Route::get('/syarat-ketentuan', [InfoController::class, 'syaratKetentuan']);
    Route::get('/panduan', [InfoController::class, 'panduan']);
    Route::get('/tentang-kami', [InfoController::class, 'tentangKami']);
});
