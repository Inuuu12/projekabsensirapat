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
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');

    // Protected admin routes (require admin authentication)
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/layout', [AdminController::class, 'layout'])->name('admin.layout');

        // Agenda & Kehadiran Internal
        Route::post('/agenda/tambah', [AdminController::class, 'kelola_Agenda']);
        Route::get('/agenda/lihat', [AdminController::class, 'lihat_Agenda'])->name('admin.agenda.lihat');
        Route::get('/agenda/cari', [AdminController::class, 'cari_Agenda']);
        
        // Daftar Ruang (Placeholder)
        Route::get('/ruang', function () {
            return view('admin.placeholder', ['title' => 'Daftar Ruang']);
        })->name('admin.ruang.lihat');

        // Data Pengguna (Placeholder)
        Route::get('/pengguna', function () {
            return view('admin.placeholder', ['title' => 'Data Pengguna']);
        })->name('admin.pengguna.lihat');

        // Filter agenda by kategori surat
        Route::get('/agenda/kategori/internal-to-internal', [AdminController::class, 'lihat_AgendaInternalToInternal']);
        Route::get('/agenda/kategori/external-to-internal', [AdminController::class, 'lihat_AgendaExternalToInternal']);
        Route::get('/agenda/kategori/internal-to-external', [AdminController::class, 'lihat_AgendaInternalToExternal']);
        Route::get('/agenda/kategori/{kategori}', [AdminController::class, 'lihat_AgendaByCategory']);
        
        Route::put('/agenda/{id}/konfigurasi-fr', [AdminController::class, 'konfigurasi_FaceRecognition']);
        Route::get('/agenda/{id}/generate-qr', [AdminController::class, 'generate_QR']);
        Route::post('/kehadiran/verifikasi', [AdminController::class, 'verifikasi_Kehadiran']);

        // Aduan & Kunjungan
        Route::get('/aduan/lihat', [AdminController::class, 'lihat_Aduan']);
        Route::put('/aduan/{id}/verifikasi', [AdminController::class, 'verifikasi_Aduan']);
        Route::post('/kunjungan/kelola', [AdminController::class, 'kelola_Kunjungan']);
        Route::get('/kunjungan', function () {
            return view('admin.placeholder', ['title' => 'Kunjungan']);
        })->name('admin.kunjungan.lihat');
        
        Route::get('/laporan/cetak', [AdminController::class, 'cetak_Laporan']);
        Route::get('/laporan', function () {
            return view('admin.placeholder', ['title' => 'Laporan']);
        })->name('admin.laporan.lihat');
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

//sidebar
Route::get('/adminlayout', function () {
    return redirect()->route('admin.layout');
});



