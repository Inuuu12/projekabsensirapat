<?php

namespace App\Http\Controllers;

use App\Models\DokumenNotulen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenNotulenController extends Controller
{
    public function uploadDokumen(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => ['required', 'exists:app_md_agenda,id_agenda'],
            'jenis_dokumen' => ['required', 'in:notulen,dokumentasi'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('file')->store('agenda-dokumen', 'public');
        $dokumenLama = DokumenNotulen::where('id_agenda', $validated['id_agenda'])
            ->where('jenis_dokumen', $validated['jenis_dokumen'])
            ->first();

        if ($dokumenLama && Storage::disk('public')->exists($dokumenLama->file_path)) {
            Storage::disk('public')->delete($dokumenLama->file_path);
        }

        $dokumen = DokumenNotulen::uploadDokumen([
            'id_agenda' => $validated['id_agenda'],
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'nama_file' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return response()->json(['success' => true, 'data' => $dokumen], 201);
    }
}
