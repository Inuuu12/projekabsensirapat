<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DokumenNotulen;
use App\Models\QRCode;
use App\Models\RuangRapat;
use App\Models\StatusAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAgendaController extends Controller
{
    public function kelola_Agenda(Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'kategori_surat' => 'required|in:internal,masuk,keluar',
            'asal_surat' => 'nullable|string|max:255',
            'ditugaskan' => 'nullable|string|max:255',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'waktu_selesai' => 'nullable',
            'kuota' => 'nullable|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'status_fr' => 'nullable|boolean',
            'status_qr' => 'nullable|string|max:50',
            'id_ruangrapat' => 'required|exists:app_md_ruangrapat,id_ruangrapat',
            'id_statusagenda' => 'required|exists:app_md_statusagenda,id_statusagenda',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('agenda-lampiran', 'public');
        }

        $validated['status_fr'] = $request->boolean('status_fr');
        $validated['status_qr'] = $validated['status_qr'] ?? 'nonaktif';

        $agenda = Agenda::create($validated);

        if ($agenda->status_qr === 'aktif') {
            QRCode::generateQR($agenda->id_agenda);
        }

        if (! $request->wantsJson()) {
            return back()->with('success', 'Agenda berhasil ditambahkan.');
        }

        return response()->json(['message' => 'Agenda berhasil dikelola/ditambahkan', 'data' => $agenda], 201);
    }

    public function lihat_Agenda(Request $request)
    {
        $kategoriSurat = $request->query('kategori_surat', 'internal');
        $validKategori = ['internal', 'masuk', 'keluar'];

        if (! in_array($kategoriSurat, $validKategori, true)) {
            $kategoriSurat = 'internal';
        }

        $keyword = $request->query('keyword');
        $agenda = Agenda::query()
            ->where('kategori_surat', $kategoriSurat)
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_agenda', 'like', "%{$keyword}%")
                        ->orWhere('lokasi', 'like', "%{$keyword}%")
                        ->orWhere('asal_surat', 'like', "%{$keyword}%")
                        ->orWhere('ditugaskan', 'like', "%{$keyword}%");
                });
            })
            ->latest('id_agenda')
            ->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $agenda]);
        }

        $admin = Auth::guard('admin')->user();
        $ruang = RuangRapat::latest('id_ruangrapat')->get();
        $statusAgenda = StatusAgenda::latest('id_statusagenda')->get();
        $agendaStats = Agenda::query()
            ->selectRaw('kategori_surat, COUNT(*) as total')
            ->groupBy('kategori_surat')
            ->pluck('total', 'kategori_surat');

        return view('admin.agenda.index', compact('admin', 'agenda', 'ruang', 'statusAgenda', 'kategoriSurat', 'agendaStats'));
    }

    public function detail_Agenda(Request $request, ?int $id = null)
    {
        $agendaId = $id ?? $request->query('id');
        $agenda = Agenda::with('statusAgenda')->findOrFail($agendaId);
        $ruang = RuangRapat::find($agenda->id_ruangrapat);
        $dokumen = DokumenNotulen::where('id_agenda', $agenda->id_agenda)
            ->latest('id_dokumen')
            ->get()
            ->keyBy('jenis_dokumen');
        $pesertaHadir = DB::table('app_md_kehadiran')
            ->join('app_md_peserta', 'app_md_kehadiran.id_peserta', '=', 'app_md_peserta.id_peserta')
            ->where('app_md_kehadiran.id_agenda', $agenda->id_agenda)
            ->select('app_md_peserta.nama', 'app_md_peserta.jabatan', 'app_md_kehadiran.created_at')
            ->latest('app_md_kehadiran.created_at')
            ->get();

        return view('admin.agenda.detail', compact('agenda', 'ruang', 'dokumen', 'pesertaHadir'));
    }

    public function upload_DokumenAgenda($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $validated = $request->validate([
            'jenis_dokumen' => 'required|in:notulen,dokumentasi',
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
        ]);

        $dokumenLama = DokumenNotulen::where('id_agenda', $agenda->id_agenda)
            ->where('jenis_dokumen', $validated['jenis_dokumen'])
            ->first();

        if ($dokumenLama && Storage::disk('public')->exists($dokumenLama->file_path)) {
            Storage::disk('public')->delete($dokumenLama->file_path);
        }

        $file = $request->file('dokumen');
        $path = $file->store('agenda-dokumen', 'public');

        DokumenNotulen::uploadDokumen([
            'id_agenda' => $agenda->id_agenda,
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'nama_file' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        $label = $validated['jenis_dokumen'] === 'notulen' ? 'Notulen' : 'Dokumentasi';

        return back()->with('success', $label . ' agenda berhasil diunggah.');
    }

    public function hapus_DokumenAgenda($id, $dokumenId)
    {
        $agenda = Agenda::findOrFail($id);
        $dokumen = DokumenNotulen::where('id_agenda', $agenda->id_agenda)->findOrFail($dokumenId);

        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return back()->with('success', 'Dokumen agenda berhasil dihapus.');
    }

    public function cari_Agenda(Request $request)
    {
        $keyword = $request->query('keyword');

        $agenda = Agenda::when($keyword, function ($query, $keyword) {
            return $query->where('nama_agenda', 'like', "%{$keyword}%")
                ->orWhere('lokasi', 'like', "%{$keyword}%")
                ->orWhere('asal_surat', 'like', "%{$keyword}%")
                ->orWhere('ditugaskan', 'like', "%{$keyword}%");
        })->get();

        return response()->json(['success' => true, 'data' => $agenda]);
    }

    public function lihat_AgendaInternalToInternal()
    {
        $agenda = Agenda::where('kategori_surat', 'internal')->latest('id_agenda')->get();

        return response()->json(['success' => true, 'kategori' => 'internal', 'data' => $agenda]);
    }

    public function lihat_AgendaExternalToInternal()
    {
        $agenda = Agenda::where('kategori_surat', 'masuk')->latest('id_agenda')->get();

        return response()->json(['success' => true, 'kategori' => 'masuk', 'data' => $agenda]);
    }

    public function lihat_AgendaInternalToExternal()
    {
        $agenda = Agenda::where('kategori_surat', 'keluar')->latest('id_agenda')->get();

        return response()->json(['success' => true, 'kategori' => 'keluar', 'data' => $agenda]);
    }

    public function lihat_AgendaByCategory($kategori)
    {
        $aliases = [
            'internal-to-internal' => 'internal',
            'external-to-internal' => 'masuk',
            'internal-to-external' => 'keluar',
        ];
        $kategori = $aliases[$kategori] ?? $kategori;
        $validCategories = ['internal', 'masuk', 'keluar'];

        if (! in_array($kategori, $validCategories, true)) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak valid'], 400);
        }

        $agenda = Agenda::where('kategori_surat', $kategori)->latest('id_agenda')->get();

        return response()->json(['success' => true, 'kategori' => $kategori, 'data' => $agenda]);
    }

    public function konfigurasi_FaceRecognition($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'status_qr' => $request->status_qr,
        ]);

        return response()->json(['message' => 'Konfigurasi Face Recognition / QR diperbarui']);
    }

    public function generate_QR($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update(['status_qr' => 'aktif']);
        $qrCode = QRCode::generateQR($agenda->id_agenda);

        return back()->with('success', 'QR Code berhasil di-generate untuk agenda: ' . $agenda->nama_agenda);
    }

    public function update_Agenda($id, Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'kategori_surat' => 'required|in:internal,masuk,keluar',
            'asal_surat' => 'nullable|string|max:255',
            'ditugaskan' => 'nullable|string|max:255',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'waktu_selesai' => 'nullable',
            'kuota' => 'nullable|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'status_fr' => 'nullable|boolean',
            'status_qr' => 'nullable|string|max:50',
            'id_ruangrapat' => 'required|exists:app_md_ruangrapat,id_ruangrapat',
            'id_statusagenda' => 'required|exists:app_md_statusagenda,id_statusagenda',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('agenda-lampiran', 'public');
        }

        $validated['status_fr'] = $request->boolean('status_fr');
        $validated['status_qr'] = $validated['status_qr'] ?? 'nonaktif';

        $agenda = Agenda::findOrFail($id);
        $agenda->update($validated);

        if ($agenda->status_qr === 'aktif') {
            QRCode::generateQR($agenda->id_agenda);
        }

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function hapus_Agenda($id)
    {
        Agenda::findOrFail($id)->delete();

        return back()->with('success', 'Agenda berhasil dihapus.');
    }
}
