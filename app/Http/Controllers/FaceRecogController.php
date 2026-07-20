<?php

namespace App\Http\Controllers;

use App\Models\FaceRecog;
use Illuminate\Http\Request;

class FaceRecogController extends Controller
{
    public function aktifkanFR(Request $request)
    {
        $data = $request->validate(['id_peserta' => ['required', 'exists:peserta,id_peserta']]);
        $faceRecog = FaceRecog::firstOrCreate(['id_peserta' => $data['id_peserta']]);
        $faceRecog->aktifkanFR();

        return response()->json(['success' => true, 'data' => $faceRecog]);
    }

    public function pindaiWajah(Request $request)
    {
        $data = $request->validate(['id_peserta' => ['required', 'exists:peserta,id_peserta']]);

        return response()->json([
            'success' => true,
            'verified' => FaceRecog::pindaiWajah($data['id_peserta']),
        ]);
    }
}
