<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Aduan;
use App\Models\DataMasukan;
use App\Models\Kunjungan;
use App\Models\Logbook;
use App\Models\Pegawai;
use App\Models\RuangRapat;
use App\Models\StatusAgenda;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // AUTHENTICATION
    // + login()
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'admin'   => Auth::guard('admin')->user()
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Kredensial salah.'], 401);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Logout berhasil']);
        }

        return redirect()->route('admin.login')->with('status', 'Anda telah logout.');
    }

        // Show login form for admin
        public function showLoginForm()
        {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            }

            return view('auth.login');
        }

        // Simple dashboard view for admin
        public function dashboard()
        {
            $admin = Auth::guard('admin')->user();
            return view('admin.dashboard.index', compact('admin'));
        }

        // Demo view for admin layout
        public function layout()
        {
            $admin = Auth::guard('admin')->user();
            return view('admin.dashboard.index', compact('admin'));
        }

        public function daftarRuang()
        {
            $admin = Auth::guard('admin')->user();
            $ruang = RuangRapat::latest('id_ruangrapat')->get();

            return view('admin.ruang.index', compact('admin', 'ruang'));
        }

        public function dataPegawai()
        {
            $admin = Auth::guard('admin')->user();
            $pegawai = Pegawai::latest('id_pegawai')->get();

            return view('admin.pegawai.index', compact('admin', 'pegawai'));
        }

        public function dataTamu()
        {
            $admin = Auth::guard('admin')->user();
            $tamu = Tamu::latest('id_tamu')->get();
            $agenda = Agenda::latest('id_agenda')->get();

            return view('admin.tamu.index', compact('admin', 'tamu', 'agenda'));
        }

        public function daftarKunjungan()
        {
            $admin = Auth::guard('admin')->user();
            $kunjungan = Kunjungan::latest('id_kunjungan')->get();

            return view('admin.kunjungan.index', compact('admin', 'kunjungan'));
        }

        public function umpanBalik()
        {
            $admin = Auth::guard('admin')->user();
            $masukan = DataMasukan::latest('id_datamasukan')->get();

            return view('admin.masukkan.index', compact('admin', 'masukan'));
        }

        public function laporan()
        {
            $admin = Auth::guard('admin')->user();
            $totalLogbook = Logbook::count();

            return view('admin.laporan.index', compact('admin', 'totalLogbook'));
        }

    // PENGATURAN AGENDA (Sesuai Class Agenda & Admin)

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
        if (! $request->wantsJson()) {
            return back()->with('success', 'Agenda berhasil ditambahkan.');
        }

        return response()->json(['message' => 'Agenda berhasil dikelola/ditambahkan', 'data' => $agenda], 201);
    }

    // + lihat_Agenda()
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
            ->selectRaw("kategori_surat, COUNT(*) as total")
            ->groupBy('kategori_surat')
            ->pluck('total', 'kategori_surat');

        return view('admin.agenda.index', compact('admin', 'agenda', 'ruang', 'statusAgenda', 'kategoriSurat', 'agendaStats'));
    }

    // + cari_Agenda() -> Admin juga bisa nyari internal
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

    // + lihat_AgendaInternalToInternal() -> Surat internal ke internal
    public function lihat_AgendaInternalToInternal()
    {
        $agenda = Agenda::where('kategori_surat', 'internal')->latest('id_agenda')->get();
        return response()->json(['success' => true, 'kategori' => 'internal', 'data' => $agenda]);
    }

    // + lihat_AgendaExternalToInternal() -> Surat external ke internal
    public function lihat_AgendaExternalToInternal()
    {
        $agenda = Agenda::where('kategori_surat', 'masuk')->latest('id_agenda')->get();
        return response()->json(['success' => true, 'kategori' => 'masuk', 'data' => $agenda]);
    }

    // + lihat_AgendaInternalToExternal() -> Surat internal ke external
    public function lihat_AgendaInternalToExternal()
    {
        $agenda = Agenda::where('kategori_surat', 'keluar')->latest('id_agenda')->get();
        return response()->json(['success' => true, 'kategori' => 'keluar', 'data' => $agenda]);
    }

    // + lihat_AgendaByCategory() -> Filter by kategori_surat
    public function lihat_AgendaByCategory($kategori)
    {
        $aliases = [
            'internal-to-internal' => 'internal',
            'external-to-internal' => 'masuk',
            'internal-to-external' => 'keluar',
        ];
        $kategori = $aliases[$kategori] ?? $kategori;
        $validCategories = ['internal', 'masuk', 'keluar'];
        
        if (!in_array($kategori, $validCategories)) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak valid'], 400);
        }

        $agenda = Agenda::where('kategori_surat', $kategori)->latest('id_agenda')->get();
        return response()->json(['success' => true, 'kategori' => $kategori, 'data' => $agenda]);
    }

    // + konfigurasi_FaceRecognition()
    public function konfigurasi_FaceRecognition($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'status_qr' => $request->status_qr // set 'aktif' atau 'nonaktif'
        ]);

        return response()->json(['message' => 'Konfigurasi Face Recognition / QR diperbarui']);
    }

    // + generate_QR()
    public function generate_QR($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json(['message' => 'QR Code berhasil di-generate untuk ID: ' . $agenda->id_agenda]);
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

        Agenda::findOrFail($id)->update($validated);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function hapus_Agenda($id)
    {
        Agenda::findOrFail($id)->delete();

        return back()->with('success', 'Agenda berhasil dihapus.');
    }

    public function store_Ruang(Request $request)
    {
        RuangRapat::create($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]));

        return back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update_Ruang($id, Request $request)
    {
        RuangRapat::findOrFail($id)->update($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]));

        return back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function hapus_Ruang($id)
    {
        RuangRapat::findOrFail($id)->delete();

        return back()->with('success', 'Ruangan berhasil dihapus.');
    }

    public function store_Pegawai(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:app_md_pegawai,nip',
            'jabatan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:app_md_pegawai,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return back()->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function update_Pegawai($id, Request $request)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:app_md_pegawai,nip,' . $id . ',id_pegawai',
            'jabatan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:app_md_pegawai,email,' . $id . ',id_pegawai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($validated);

        return back()->with('success', 'Data pegawai berhasil diperbarui!');
    }
    public function hapus_Pegawai($id)
    {
        Pegawai::findOrFail($id)->delete();

        return back()->with('success', 'Pegawai berhasil dihapus.');
    }

    public function store_Tamu(Request $request)
    {
        Tamu::create($request->validate([
            'nik' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:30',
            'asal_instansi' => 'required|string|max:255',
            'id_agenda' => 'required|exists:app_md_agenda,id_agenda',
        ]));

        return back()->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function update_Tamu($id, Request $request)
    {
        Tamu::findOrFail($id)->update($request->validate([
            'nik' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:30',
            'asal_instansi' => 'required|string|max:255',
            'id_agenda' => 'required|exists:app_md_agenda,id_agenda',
        ]));

        return back()->with('success', 'Tamu berhasil diperbarui.');
    }

    public function hapus_Tamu($id)
    {
        Tamu::findOrFail($id)->delete();

        return back()->with('success', 'Tamu berhasil dihapus.');
    }

    // + verifikasi_Kehadiran() -> Mengesahkan absensi manual/logbook oleh admin jika sistem error
    public function verifikasi_Kehadiran(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => 'required|integer',
            'catatan'   => 'required|string'
        ]);

        $log = Logbook::create([
            'id_agenda' => $validated['id_agenda'],
            'catatan'   => '[Diverifikasi Admin] ' . $validated['catatan'],
            'waktu_isi' => Carbon::now()
        ]);

        return response()->json(['message' => 'Kehadiran berhasil diverifikasi oleh admin', 'data' => $log]);
    }

    // FITUR ADUAN & KUNJUNGAN

    // + lihat_Aduan()
    public function lihat_Aduan()
    {
        $aduan = Aduan::all();
        return response()->json(['success' => true, 'data' => $aduan]);
    }

    // + verifikasi_Aduan()
    public function verifikasi_Aduan($id, Request $request)
    {
        // Validasi input agar status yang dikirimkan hanya boleh 'Di Baca' atau 'Pending'
        $request->validate([
            'status' => 'required|string|in:Pending,Di Baca'
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status aduan berhasil diperbarui menjadi: ' . $aduan->status,
            'data'    => $aduan
        ]);
    }

    // + kelola_Kunjungan()
    public function kelola_Kunjungan(Request $request)
    {
        $validated = $request->validate([
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:30',
            'email_pengunjung' => 'nullable|email|max:255|unique:app_md_kunjungan,email_pengunjung',
            'keperluan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);
        $validated['id_admin'] = Auth::guard('admin')->id();

        $kunjungan = Kunjungan::create($validated);
        if (! $request->wantsJson()) {
            return back()->with('success', 'Kunjungan berhasil ditambahkan.');
        }

        return response()->json(['message' => 'Data kunjungan berhasil dikelola', 'data' => $kunjungan]);
    }

    public function update_Kunjungan($id, Request $request)
    {
        $validated = $request->validate([
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:30',
            'email_pengunjung' => 'nullable|email|max:255|unique:app_md_kunjungan,email_pengunjung,' . $id . ',id_kunjungan',
            'keperluan' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        Kunjungan::findOrFail($id)->update($validated);

        return back()->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function hapus_Kunjungan($id)
    {
        Kunjungan::findOrFail($id)->delete();

        return back()->with('success', 'Kunjungan berhasil dihapus.');
    }

    public function update_Masukan($id, Request $request)
    {
        DataMasukan::findOrFail($id)->update($request->validate([
            'status' => 'required|string|max:50',
        ]));

        return back()->with('success', 'Status masukkan berhasil diperbarui.');
    }

    public function reply_Masukan($id, Request $request)
    {
        $validated = $request->validate([
            'balasan_admin' => 'required|string|max:5000',
        ]);

        DataMasukan::findOrFail($id)->update([
            'balasan_admin' => $validated['balasan_admin'],
            'status' => 'Diproses',
            'id_admin' => Auth::guard('admin')->id(),
        ]);

        return back()->with('success', 'Balasan masukkan berhasil disimpan.');
    }

    public function hapus_Masukan($id)
    {
        DataMasukan::findOrFail($id)->delete();

        return back()->with('success', 'Masukkan berhasil dihapus.');
    }

    // + cetak_Laporan()
    public function cetak_Laporan()
    {
        $logbook = Logbook::all();
        return response()->json(['message' => 'Laporan logbook berhasil ditarik', 'data' => $logbook]);
    }
}
