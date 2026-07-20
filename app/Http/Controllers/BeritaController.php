<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function ambilBerita()
    {
        return response()->json(['success' => true, 'data' => Berita::ambilBerita()]);
    }

    public function cariBerita(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => Berita::cariBerita((string) $request->query('keyword', '')),
        ]);
    }
}
