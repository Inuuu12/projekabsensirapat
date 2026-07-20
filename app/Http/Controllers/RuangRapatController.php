<?php

namespace App\Http\Controllers;

use App\Models\RuangRapat;
use Illuminate\Http\Request;

class RuangRapatController extends Controller
{
    public function tersedia(int $id, Request $request)
    {
        $ruang = RuangRapat::findOrFail($id);

        return response()->json([
            'success' => true,
            'tersedia' => $ruang->tersedia($request->query('tanggal'), $request->query('jadwal')),
        ]);
    }
}
