<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/admin/login')->name('login');

// ROUTE GRUP ADMIN
Route::prefix('admin')->group(function () {
    // Show login form
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Protected admin routes (require admin authentication)
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/layout', [AdminController::class, 'layout'])->name('admin.layout');

        // Agenda & Kehadiran Internal
        Route::post('/agenda/tambah', [AdminController::class, 'kelola_Agenda'])->name('admin.agenda.store');
        Route::get('/agenda/lihat', [AdminController::class, 'lihat_Agenda'])->name('admin.agenda.lihat');
        
        // RUTE DETAIL AGENDA (Menghilangkan Error RouteNotFoundException)
        Route::get('/agenda/detail', function () {
            return view('admin.agenda.detail');
        })->name('admin.agenda.detail');

        Route::redirect('/agenda', '/admin/agenda/lihat')->name('admin.agenda');
        Route::get('/agenda/cari', [AdminController::class, 'cari_Agenda']);
        
        // Halaman admin
        Route::get('/ruang', [AdminController::class, 'daftarRuang'])->name('admin.ruang.lihat');

        Route::get('/pengguna', [AdminController::class, 'dataPegawai'])->name('admin.pengguna.lihat');
        Route::get('/datapegawai', [AdminController::class, 'dataPegawai'])->name('admin.datapegawai');
        Route::get('/pegawai', [AdminController::class, 'dataPegawai'])->name('admin.pegawai.lihat');
        Route::get('/datatamu', [AdminController::class, 'dataTamu'])->name('admin.datatamu');
        Route::get('/tamu', [AdminController::class, 'dataTamu'])->name('admin.tamu.lihat');
        Route::get('/umpanbalik', [AdminController::class, 'umpanBalik'])->name('admin.umpanbalik');
        Route::get('/masukkan', [AdminController::class, 'umpanBalik'])->name('admin.masukkan.lihat');

        // Filter agenda by kategori surat
        Route::get('/agenda/kategori/internal-to-internal', [AdminController::class, 'lihat_AgendaInternalToInternal']);
        Route::get('/agenda/kategori/external-to-internal', [AdminController::class, 'lihat_AgendaExternalToInternal']);
        Route::get('/agenda/kategori/internal-to-external', [AdminController::class, 'lihat_AgendaInternalToExternal']);
        Route::get('/agenda/kategori/{kategori}', [AdminController::class, 'lihat_AgendaByCategory']);
        
        Route::put('/agenda/{id}/konfigurasi-fr', [AdminController::class, 'konfigurasi_FaceRecognition']);
        Route::get('/agenda/{id}/generate-qr', [AdminController::class, 'generate_QR']);
        Route::put('/agenda/{id}', [AdminController::class, 'update_Agenda'])->name('admin.agenda.update');
        Route::delete('/agenda/{id}', [AdminController::class, 'hapus_Agenda'])->name('admin.agenda.destroy');
        Route::post('/kehadiran/verifikasi', [AdminController::class, 'verifikasi_Kehadiran']);

        // Aduan & Kunjungan
        Route::get('/aduan/lihat', [AdminController::class, 'lihat_Aduan']);
        Route::put('/aduan/{id}/verifikasi', [AdminController::class, 'verifikasi_Aduan']);
        Route::post('/kunjungan/kelola', [AdminController::class, 'kelola_Kunjungan'])->name('admin.kunjungan.store');
        Route::put('/kunjungan/{id}', [AdminController::class, 'update_Kunjungan'])->name('admin.kunjungan.update');
        Route::delete('/kunjungan/{id}', [AdminController::class, 'hapus_Kunjungan'])->name('admin.kunjungan.destroy');
        Route::get('/kunjungan', [AdminController::class, 'daftarKunjungan'])->name('admin.kunjungan.lihat');
        Route::get('/daftarkunjungan', [AdminController::class, 'daftarKunjungan'])->name('admin.daftarkunjungan');
        
        Route::get('/laporan/cetak', [AdminController::class, 'cetak_Laporan']);
        Route::get('/kehadiran/download', [AdminController::class, 'cetak_Laporan'])->name('admin.kehadiran.download');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan.lihat');

        Route::post('/ruang', [AdminController::class, 'store_Ruang'])->name('admin.ruang.store');
        Route::put('/ruang/{id}', [AdminController::class, 'update_Ruang'])->name('admin.ruang.update');
        Route::delete('/ruang/{id}', [AdminController::class, 'hapus_Ruang'])->name('admin.ruang.destroy');

        Route::post('/pegawai', [AdminController::class, 'store_Pegawai'])->name('admin.pegawai.store');
        Route::put('/pegawai/{id}', [AdminController::class, 'update_Pegawai'])->name('admin.pegawai.update');
        Route::delete('/pegawai/{id}', [AdminController::class, 'hapus_Pegawai'])->name('admin.pegawai.destroy');

        Route::post('/tamu', [AdminController::class, 'store_Tamu'])->name('admin.tamu.store');
        Route::put('/tamu/{id}', [AdminController::class, 'update_Tamu'])->name('admin.tamu.update');
        Route::delete('/tamu/{id}', [AdminController::class, 'hapus_Tamu'])->name('admin.tamu.destroy');

        Route::put('/masukkan/{id}', [AdminController::class, 'update_Masukan'])->name('admin.masukkan.update');
        Route::delete('/masukkan/{id}', [AdminController::class, 'hapus_Masukan'])->name('admin.masukkan.destroy');
    });
});

// Routes Kehadiran
Route::post('/kehadiran/scan-qr', [KehadiranController::class, 'scan_QR']);
Route::post('/kehadiran/verifikasi-fr', [KehadiranController::class, 'verifikasi_FaceRecognition']);

// Fitur pengaduan masyarakat
Route::post('/aduan/kirim', [UserController::class, 'kirimAduan']);
Route::get('/aduan/cek/{id}', [UserController::class, 'cekStatusAduan']);

// Fitur cari jadwal agenda rapat publik
Route::get('/agenda/cari', [UserController::class, 'CariAgenda']);

// ROUTE MILIK USER
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

// Sidebar
Route::get('/adminlayout', function () {
    return redirect()->route('admin.layout');
});
<<<<<<< HEAD
=======

Route::get('/publik', function () {
    return view('publik.index');
})->name('publik.beranda');

Route::get('/publik/agenda', function () {
    return view('publik.agenda');
})->name('publik.agenda');

Route::get('/publik/agenda/detail', function () {
    return view('publik.agenda-detail');
});

Route::get('/publik/agenda-detail', function () {
    return view('publik.agenda-detail');
})->name('publik.agenda-detail');

Route::get('/publik/index-v2', function () {
    return view('publik.index-v2');
})->name('publik.index-v2');

Route::get('/publik/berita', function () {
    return view('publik.berita');
})->name('publik.berita');

Route::get('/publik/berita/detail', function () {
    return view('publik.berita-detail');
});

Route::get('/publik/masukan', function () {
    return view('publik.masukan');
})->name('publik.masukan');

Route::redirect('/publik/feedback', '/publik/masukan');

Route::get('/publik/ulang-tahun', function () {
    return view('publik.ulang-tahun');
})->name('publik.ulang-tahun');

Route::redirect('/publik/ulangtahun', '/publik/ulang-tahun')->name('publik.ulangtahun');

Route::get('/publik/galeri', function () {
    return view('publik.galeri');
})->name('publik.galeri');

Route::get('/publik/video', function () {
    return view('publik.video');
})->name('publik.video');

Route::get('/publik/index', function () {
    return view('publik.index');
})->name('publik.index');

Route::get('/publik/berita-detail', function () {
    return view('publik.berita-detail');
})->name('publik.berita-detail');
>>>>>>> 80519bc (views publik & edit routes)
