<?php

namespace App\Http\Controllers;

use App\Models\DokumenNotulen;
use Illuminate\Http\Request;

class DokumenNotulenController extends Controller
{
    public function uploadDokumen(Request $request)
    {
        $dokumen = DokumenNotulen::uploadDokumen($request->validate([
            'id_agenda' => ['nullable', 'exists:agenda,id_agenda'],
            'namaFile' => ['required', 'string', 'max:255'],
            'filePath' => ['required', 'string', 'max:255'],
        ]));

        return response()->json(['success' => true, 'data' => $dokumen], 201);
    }
}
