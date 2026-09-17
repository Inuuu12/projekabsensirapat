<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\PengajuanAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPengajuanAgendaController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', 'semua');

        $query = PengajuanAgenda::with(['pegawai', 'ruangRapat', 'dinas', 'kecamatan'])
            ->latest();

        if (in_array($statusFilter, ['pending', 'disetujui', 'ditolak'])) {
            $query->where('status', $statusFilter);
        }

        $pengajuanList = $query->paginate(15);

        $totalPending = PengajuanAgenda::where('status', 'pending')->count();
        $totalDisetujui = PengajuanAgenda::where('status', 'disetujui')->count();
        $totalDitolak = PengajuanAgenda::where('status', 'ditolak')->count();

        return view('admin.pengajuan.index', compact(
            'pengajuanList',
            'statusFilter',
            'totalPending',
            'totalDisetujui',
            'totalDitolak'
        ));
    }

    public function setujui($id)
    {
        $pengajuan = PengajuanAgenda::findOrFail($id);

        if ($pengajuan->status === 'disetujui') {
            return back()->with('info', 'Pengajuan ini sudah disetujui sebelumnya.');
        }

        // Cek bentrok jadwal ruangan sebelum disetujui
        if (!empty($pengajuan->id_ruangrapat)) {
            $ruang = \App\Models\RuangRapat::withoutGlobalScopes()->find($pengajuan->id_ruangrapat);
            if ($ruang) {
                $conflict = $ruang->checkScheduleConflict(
                    $pengajuan->tanggal,
                    $pengajuan->waktu,
                    $pengajuan->waktu_selesai ?? null,
                    null,
                    $pengajuan->id_pengajuan
                );

                if ($conflict) {
                    $tglFormatted = \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('d M Y');
                    return back()->with('error', "Gagal menyetujui! Ruangan {$ruang->nama_ruang} sudah terpakai/terbooking pada {$tglFormatted} pukul {$conflict['waktu_mulai']} - {$conflict['waktu_selesai']} WIB untuk agenda '{$conflict['nama']}' ({$conflict['sumber']}).");
                }
            }
        }

        $pengajuan->status = 'disetujui';
        $pengajuan->save();

        // Otomatis buatkan record Agenda resmi agar masuk ke sistem presensi & booking
        $lokasi = $pengajuan->ruangRapat?->nama_ruang ?? 'Kantor Dinas';

        $statusLabel = Agenda::resolveStatusLabel(
            $pengajuan->tanggal,
            $pengajuan->waktu,
            $pengajuan->waktu_selesai
        );
        $idStatusAgenda = match ($statusLabel) {
            Agenda::STATUS_BERLANGSUNG => 2,
            Agenda::STATUS_SELESAI => 3,
            default => 1,
        };

        $agenda = Agenda::create([
            'nama_agenda' => $pengajuan->nama_agenda,
            'kategori_surat' => 'internal',
            'asal_surat' => $pengajuan->penyelenggara ?: ($pengajuan->pegawai?->nama_pegawai ?? 'Pengajuan Pegawai'),
            'tanggal' => $pengajuan->tanggal,
            'waktu' => $pengajuan->waktu,
            'waktu_selesai' => $pengajuan->waktu_selesai,
            'id_ruangrapat' => $pengajuan->id_ruangrapat,
            'id_statusagenda' => $idStatusAgenda,
            'kuota' => $pengajuan->kuota ?? 20,
            'lokasi' => $lokasi,
            'status_fr' => 1,
            'status_qr' => 'aktif',
            'id_dinas' => $pengajuan->id_dinas,
            'id_kecamatan' => $pengajuan->id_kecamatan,
        ]);

        if (class_exists(\App\Models\QRCode::class)) {
            \App\Models\QRCode::generateQR($agenda->id_agenda);
        }

        return back()->with('success', 'Pengajuan agenda berhasil disetujui dan telah masuk ke Daftar Agenda resmi.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $pengajuan = PengajuanAgenda::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->catatan_admin = $request->catatan_admin ?? 'Pengajuan agenda ditolak oleh admin.';
        $pengajuan->save();

        return back()->with('success', 'Pengajuan agenda telah ditolak.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanAgenda::findOrFail($id);
        $pengajuan->delete();

        return back()->with('success', 'Data pengajuan agenda berhasil dihapus.');
    }
}
