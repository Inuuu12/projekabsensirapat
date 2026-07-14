<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\PublicAgendaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// ROUTE GRUP ADMIN
Route::prefix('admin')->group(function () {
    // Show login form
    Route::get('/login', [AdminController::class, 'showLoginForm']);
    Route::post('/login', [AdminController::class, 'login']);

    // Protected admin routes (require admin authentication)
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Agenda & Kehadiran Internal
        Route::post('/agenda/tambah', [AdminController::class, 'kelola_Agenda']);
        Route::get('/agenda/lihat', [AdminController::class, 'lihat_Agenda']);
        Route::get('/agenda/cari', [AdminController::class, 'cari_Agenda']);
        Route::put('/agenda/{id}/konfigurasi-fr', [AdminController::class, 'konfigurasi_FaceRecognition']);
        Route::get('/agenda/{id}/generate-qr', [AdminController::class, 'generate_QR']);
        Route::post('/kehadiran/verifikasi', [AdminController::class, 'verifikasi_Kehadiran']);

        // Aduan & Kunjungan
        Route::get('/aduan/lihat', [AdminController::class, 'lihat_Aduan']);
        Route::put('/aduan/{id}/verifikasi', [AdminController::class, 'verifikasi_Aduan']);
        Route::post('/kunjungan/kelola', [AdminController::class, 'kelola_Kunjungan']);
        Route::get('/laporan/cetak', [AdminController::class, 'cetak_Laporan']);
    });
});

   //Routes Kehadiran
   // Route untuk absensi Pegawai / Tamu
    Route::post('/kehadiran/scan-qr', [KehadiranController::class, 'scan_QR']);
    Route::post('/kehadiran/verifikasi-fr', [KehadiranController::class, 'verifikasi_FaceRecognition']);

    // fitur pengaduan masyarakat
    Route::post('/aduan/kirim', [AduanController::class, 'kirim_Aduan']);
    Route::get('/aduan/cek/{id}', [AduanController::class, 'cek_StatusAduan']);

    // fitur cari jadwal agenda rapat publik
    Route::get('/agenda/cari', [PublicAgendaController::class, 'cari_Agenda']);

    //ROUTE MILIK USER
    Route::prefix('user')->group(function () {
    // Halaman Beranda Informasi Publik
    Route::get('/beranda/pengumuman', [UserController::class, 'TampilkanPengumuman']);
    Route::get('/beranda/ringkasan', [UserController::class, 'TampilkanRingkasan']);

    // Informasi Agenda Rapat Terbuka Publik
    Route::get('/agenda/list', [UserController::class, 'listAgenda']);
    Route::get('/agenda/cari', [UserController::class, 'CariAgenda']);
    Route::get('/agenda/qr/{id}', [UserController::class, 'tampilkanQrKode']);

    // Manajemen Layanan Pengaduan (Aduan)
    Route::post('/aduan/kirim', [UserController::class, 'kirimAduan']);
    Route::get('/aduan/status/{id}', [UserController::class, 'cekStatusAduan']);

    // Pendaftaran Kehadiran Tamu (Non-Pegawai)
    Route::post('/tamu/hadir', [UserController::class, 'inputDataTamu']);
});

