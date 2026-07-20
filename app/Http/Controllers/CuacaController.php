<?php

namespace App\Http\Controllers;

use App\Models\Cuaca;
use Illuminate\Http\Request;

class CuacaController extends Controller
{
    public function ambilCuaca()
    {
        return response()->json(['success' => true, 'data' => Cuaca::ambilCuaca()]);
    }

    public function cariCuaca(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => Cuaca::cariCuaca((string) $request->query('lokasi', '')),
        ]);
    }
}
