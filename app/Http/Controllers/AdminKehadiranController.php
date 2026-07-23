<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminKehadiranController extends Controller
{
    public function verifikasi_Kehadiran(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => 'required|integer',
            'catatan' => 'required|string',
        ]);

        $log = Logbook::create([
            'id_agenda' => $validated['id_agenda'],
            'catatan' => '[Diverifikasi Admin] ' . $validated['catatan'],
            'waktu_isi' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Kehadiran berhasil diverifikasi oleh admin', 'data' => $log]);
    }
}
