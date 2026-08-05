<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{
    public function scan_QR(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => 'nullable|integer',
            'qr_code' => 'nullable|string',
        ]);

        $agendaId = $validated['id_agenda'] ?? null;

        if (! $agendaId && ! empty($validated['qr_code'])) {
            $qrCode = QRCode::where('qr_codepath', $validated['qr_code'])
                ->orWhere('qr_codepath', 'like', '%' . $validated['qr_code'] . '%')
                ->first();

            $agendaId = $qrCode?->id_agenda;
        }

        if (! $agendaId) {
            return response()->json([
                'success' => false,
                'message' => 'QR code tidak valid atau agenda tidak ditemukan.',
            ], 422);
        }

        $agenda = Agenda::find($agendaId);

        if (! $agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR code valid.',
            'data' => $agenda,
        ]);
    }

    public function verifikasi_FaceRecognition(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => 'required|integer|exists:sirapi_md_agenda,id_agenda',
            'id_peserta' => 'nullable|integer|exists:sirapi_md_peserta,id_peserta',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $now = now();

        $idLog = DB::table('sirapi_md_logbook')->insertGetId([
            'Id_agenda' => $validated['id_agenda'],
            'catatan' => $validated['catatan'] ?? 'Verifikasi face recognition berhasil.',
            'waktu_isi' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if (! empty($validated['id_peserta'])) {
            DB::table('sirapi_md_kehadiran')->updateOrInsert(
                [
                    'id_agenda' => $validated['id_agenda'],
                    'id_peserta' => $validated['id_peserta'],
                ],
                [
                    'id_log' => $idLog,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi face recognition berhasil.',
            'id_log' => $idLog,
        ]);
    }
}
