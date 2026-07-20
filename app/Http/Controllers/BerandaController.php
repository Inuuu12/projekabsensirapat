<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Cuaca;
use App\Models\Galeri;
use App\Models\Masukan;
use App\Models\UlangTahun;

class BerandaController extends Controller
{
    public function tampilkanAgenda()
    {
        return response()->json(['success' => true, 'data' => Agenda::with('statusAgenda')->latest('jadwal')->get()]);
    }

    public function tampilkanBerita()
    {
        return response()->json(['success' => true, 'data' => Berita::ambilBerita()]);
    }

    public function tampilkanGaleri()
    {
        return response()->json(['success' => true, 'data' => Galeri::tampilFoto()]);
    }

    public function tampilkanMasukan()
    {
        return response()->json(['success' => true, 'data' => Masukan::with('statusMasukan')->latest()->get()]);
    }

    public function tampilkanUlangTahun()
    {
        return response()->json(['success' => true, 'data' => UlangTahun::tampilkanUlangTahunPegawai()]);
    }

    public function tampilkanCuaca()
    {
        return response()->json(['success' => true, 'data' => Cuaca::ambilCuaca()]);
    }
}
