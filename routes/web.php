<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\AdminController;

Route::get('/', function () {
    return view('welcome');
});

//Routes Admin
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);

    // Fitur Agenda
    Route::post('/agenda/tambah', [AdminController::class, 'tambah_Agenda']);
    Route::get('/agenda/lihat', [AdminController::class, 'lihat_Agenda']);
    Route::put('/agenda/{id}/konfigurasi-fr', [AdminController::class, 'konfigurasi_FaceRecognition']);
    Route::get('/agenda/{id}/generate-qr', [AdminController::class, 'generate_QR']);

    // Fitur Aduan
    Route::get('/aduan/lihat', [AdminController::class, 'lihat_Aduan']);
    Route::put('/aduan/{id}/verifikasi', [AdminController::class, 'verifikasi_Aduan']);

    // Fitur Kunjungan & Laporan
    Route::post('/kunjungan/kelola', [AdminController::class, 'kelola_Kunjungan']);
    Route::get('/laporan/cetak', [AdminController::class, 'cetak_Laporan']);
});

