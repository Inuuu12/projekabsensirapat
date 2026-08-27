<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DokumenNotulen;
use App\Models\Pegawai;
use App\Models\QRCode;
use App\Models\RuangRapat;
use App\Models\StatusAgenda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAgendaController extends Controller
{
    public function kelola_Agenda(Request $request)
    {
        $isMasuk = $request->input('kategori_surat') === 'masuk';

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
            'id_ruangrapat' => $isMasuk ? 'nullable|exists:sirapi_md_ruangrapat,id_ruangrapat' : 'required|exists:sirapi_md_ruangrapat,id_ruangrapat',
            'id_statusagenda' => 'nullable|exists:sirapi_md_statusagenda,id_statusagenda',
        ]);

        if (empty($validated['id_ruangrapat'])) {
            $defaultRuang = RuangRapat::first();
            $validated['id_ruangrapat'] = $defaultRuang?->id_ruangrapat ?? 1;
        }

        // Validasi Bentrok Jadwal Ruangan
        if (! $isMasuk && ! empty($validated['id_ruangrapat'])) {
            $ruang = RuangRapat::find($validated['id_ruangrapat']);
            if ($ruang) {
                $validated['lokasi'] = $ruang->nama_ruang;

                $conflict = $ruang->checkConflict(
                    $validated['tanggal'],
                    $validated['waktu'],
                    $validated['waktu_selesai'] ?? null
                );

                if ($conflict) {
                    $waktuMulaiConf = substr((string) $conflict->waktu, 0, 5);
                    $waktuSelesaiConf = $conflict->waktu_selesai ? substr((string) $conflict->waktu_selesai, 0, 5) : 'selesai';
                    $tanggalConf = Carbon::parse($conflict->tanggal)->translatedFormat('d F Y');
                    $msg = "Ruangan {$ruang->nama_ruang} tidak dapat dipilih karena sudah terpakai pada {$tanggalConf} pukul {$waktuMulaiConf} - {$waktuSelesaiConf} WIB untuk agenda '{$conflict->nama_agenda}'.";

                    if ($request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => $msg], 422);
                    }

                    return back()->withInput()->with('error', $msg);
                }
            }
        }

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('agenda-lampiran', 'public');
        }

        $validated['status_fr'] = $request->boolean('status_fr');
        $validated['status_qr'] = $validated['status_qr'] ?? 'nonaktif';
        $validated['id_statusagenda'] = $this->statusAgendaIdFor($validated);

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
        $pegawaiList = Pegawai::orderBy('bidang')->orderBy('nama_pegawai')->get();
        $agendaStats = Agenda::query()
            ->selectRaw('kategori_surat, COUNT(*) as total')
            ->groupBy('kategori_surat')
            ->pluck('total', 'kategori_surat');

        return view('admin.agenda.index', compact('admin', 'agenda', 'ruang', 'pegawaiList', 'kategoriSurat', 'agendaStats'));
    }

    public function detail_Agenda(Request $request, ?int $id = null)
    {
        $agendaId = $id ?? $request->query('id');
        $agenda = Agenda::findOrFail($agendaId);
        $ruang = RuangRapat::find($agenda->id_ruangrapat);
        $dokumen = DokumenNotulen::where('id_agenda', $agenda->id_agenda)
            ->latest('id_dokumen')
            ->get();
        $qrCode = QRCode::where('id_agenda', $agenda->id_agenda)->first();
        $pesertaHadir = DB::table('sirapi_md_kehadiran')
            ->join('sirapi_md_peserta', 'sirapi_md_kehadiran.id_peserta', '=', 'sirapi_md_peserta.id_peserta')
            ->where('sirapi_md_kehadiran.id_agenda', $agenda->id_agenda)
            ->select('sirapi_md_peserta.nama', 'sirapi_md_peserta.jabatan', 'sirapi_md_kehadiran.created_at')
            ->latest('sirapi_md_kehadiran.created_at')
            ->get();

        return view('admin.agenda.detail', compact('agenda', 'ruang', 'dokumen', 'qrCode', 'pesertaHadir'));
    }

    public function upload_DokumenAgenda($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $jenisDokumen = (string) $request->input('jenis_dokumen');
        $validated = $request->validate($jenisDokumen === 'dokumentasi'
            ? [
                'jenis_dokumen' => 'required|in:dokumentasi',
                'dokumen' => 'required|array',
                'dokumen.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
            ]
            : [
                'jenis_dokumen' => 'required|in:notulen',
                'dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
            ]);

        $files = $request->file('dokumen');
        $files = is_array($files) ? $files : [$files];

        if ($validated['jenis_dokumen'] === 'notulen' && count($files) > 1) {
            return back()->withErrors(['dokumen' => 'Notulen hanya boleh satu file.'])->withInput();
        }

        if ($validated['jenis_dokumen'] === 'notulen') {
            $dokumenLama = DokumenNotulen::where('id_agenda', $agenda->id_agenda)
                ->where('jenis_dokumen', $validated['jenis_dokumen'])
                ->first();

            if ($dokumenLama && Storage::disk('public')->exists($dokumenLama->file_path)) {
                Storage::disk('public')->delete($dokumenLama->file_path);
            }
        }

        foreach ($files as $file) {
            $path = $file->store('agenda-dokumen', 'public');

            DokumenNotulen::uploadDokumen([
                'id_agenda' => $agenda->id_agenda,
                'jenis_dokumen' => $validated['jenis_dokumen'],
                'nama_file' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);
        }

        $label = $validated['jenis_dokumen'] === 'notulen' ? 'Notulen' : 'Dokumentasi';
        $jumlah = count($files);

        return back()->with('success', $label . ' agenda berhasil diunggah' . ($jumlah > 1 ? " ({$jumlah} file)." : '.'));
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
        $isMasuk = $request->input('kategori_surat') === 'masuk';

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
            'id_ruangrapat' => $isMasuk ? 'nullable|exists:sirapi_md_ruangrapat,id_ruangrapat' : 'required|exists:sirapi_md_ruangrapat,id_ruangrapat',
            'id_statusagenda' => 'nullable|exists:sirapi_md_statusagenda,id_statusagenda',
        ]);

        if (empty($validated['id_ruangrapat'])) {
            $defaultRuang = RuangRapat::first();
            $validated['id_ruangrapat'] = $defaultRuang?->id_ruangrapat ?? 1;
        }

        // Validasi Bentrok Jadwal Ruangan
        if (! $isMasuk && ! empty($validated['id_ruangrapat'])) {
            $ruang = RuangRapat::find($validated['id_ruangrapat']);
            if ($ruang) {
                $validated['lokasi'] = $ruang->nama_ruang;

                $conflict = $ruang->checkConflict(
                    $validated['tanggal'],
                    $validated['waktu'],
                    $validated['waktu_selesai'] ?? null,
                    (int) $id
                );

                if ($conflict) {
                    $waktuMulaiConf = substr((string) $conflict->waktu, 0, 5);
                    $waktuSelesaiConf = $conflict->waktu_selesai ? substr((string) $conflict->waktu_selesai, 0, 5) : 'selesai';
                    $tanggalConf = Carbon::parse($conflict->tanggal)->translatedFormat('d F Y');
                    $msg = "Ruangan {$ruang->nama_ruang} tidak dapat dipilih karena sudah terpakai pada {$tanggalConf} pukul {$waktuMulaiConf} - {$waktuSelesaiConf} WIB untuk agenda '{$conflict->nama_agenda}'.";

                    return back()->withInput()->with('error', $msg);
                }
            }
        }

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('agenda-lampiran', 'public');
        }

        $validated['status_fr'] = $request->boolean('status_fr');
        $validated['status_qr'] = $validated['status_qr'] ?? 'nonaktif';
        $validated['id_statusagenda'] = $this->statusAgendaIdFor($validated);

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

    private function statusAgendaIdFor(array $agenda): int
    {
        $status = Agenda::resolveStatusLabel(
            $agenda['tanggal'],
            $agenda['waktu'],
            $agenda['waktu_selesai'] ?? null,
        );

        return StatusAgenda::firstOrCreate(['nama_status' => $status])->id_statusagenda;
    }
}
