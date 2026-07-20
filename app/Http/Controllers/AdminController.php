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
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return view('admin.dashboard', compact('admin'));
        }

        // Demo view for admin layout
        public function layout()
        {
            $admin = Auth::guard('admin')->user();
            return view('admin.dashboard', compact('admin'));
        }

        public function daftarRuang()
        {
            $admin = Auth::guard('admin')->user();
            $ruang = RuangRapat::latest('id_ruangrapat')->get();

            return view('admin.daftarruangan', compact('admin', 'ruang'));
        }

        public function dataPegawai()
        {
            $admin = Auth::guard('admin')->user();
            $pegawai = Pegawai::latest('id_pegawai')->get();

            return view('admin.datapegawai', compact('admin', 'pegawai'));
        }

        public function dataTamu()
        {
            $admin = Auth::guard('admin')->user();
            $tamu = Tamu::latest('id_tamu')->get();

            return view('admin.datatamu', compact('admin', 'tamu'));
        }

        public function daftarKunjungan()
        {
            $admin = Auth::guard('admin')->user();
            $kunjungan = Kunjungan::latest('id_kunjungan')->get();

            return view('admin.daftarkunjungan', compact('admin', 'kunjungan'));
        }

        public function umpanBalik()
        {
            $admin = Auth::guard('admin')->user();
            $masukan = DataMasukan::latest('id_datamasukan')->get();

            return view('admin.umpanbalik', compact('admin', 'masukan'));
        }

        public function laporan()
        {
            $admin = Auth::guard('admin')->user();
            $totalLogbook = Logbook::count();

            return view('admin.laporan', compact('admin', 'totalLogbook'));
        }

    // PENGATURAN AGENDA (Sesuai Class Agenda & Admin)

    public function kelola_Agenda(Request $request)
    {
        $validated = $request->validate([
            'judul'                 => 'required|string|max:255',
            'tanggal'               => 'required|date',
            'waktu'                 => 'required',
            'lokasi'                => 'required|string',
            'kategori_surat'        => 'nullable|in:internal->internal,external->internal,internal->external',
            'status_FaceRecognition' => 'nullable|boolean',
            'status_qr'             => 'nullable|in:aktif,nonaktif',
            'file_undangan'         => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('file_undangan')) {
            $file = $request->file('file_undangan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('undangan', $fileName);
            $validated['file_undangan'] = $filePath;
        }

        $agenda = Agenda::create($validated);
        return response()->json(['message' => 'Agenda berhasil dikelola/ditambahkan', 'data' => $agenda], 201);
    }

    // + lihat_Agenda()
    public function lihat_Agenda(Request $request)
    {
        $agenda = Agenda::all();
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $agenda]);
        }
        $admin = Auth::guard('admin')->user();

        return view('admin.daftaragenda', compact('admin', 'agenda'));
    }

    // + cari_Agenda() -> Admin juga bisa nyari internal
    public function cari_Agenda(Request $request)
    {
        $keyword = $request->query('keyword');
        $kategori = $request->query('kategori');
        
        $agenda = Agenda::when($keyword, function ($query, $keyword) {
            return $query->where('judul', 'like', "%{$keyword}%");
        })
        ->when($kategori, function ($query, $kategori) {
            return $query->where('kategori_surat', $kategori);
        })
        ->get();

        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // + lihat_AgendaInternalToInternal() -> Surat internal ke internal
    public function lihat_AgendaInternalToInternal()
    {
        $agenda = Agenda::internalToInternal()->get();
        return response()->json(['success' => true, 'kategori' => 'internal->internal', 'data' => $agenda]);
    }

    // + lihat_AgendaExternalToInternal() -> Surat external ke internal
    public function lihat_AgendaExternalToInternal()
    {
        $agenda = Agenda::externalToInternal()->get();
        return response()->json(['success' => true, 'kategori' => 'external->internal', 'data' => $agenda]);
    }

    // + lihat_AgendaInternalToExternal() -> Surat internal ke external
    public function lihat_AgendaInternalToExternal()
    {
        $agenda = Agenda::internalToExternal()->get();
        return response()->json(['success' => true, 'kategori' => 'internal->external', 'data' => $agenda]);
    }

    // + lihat_AgendaByCategory() -> Filter by kategori_surat
    public function lihat_AgendaByCategory($kategori)
    {
        $validCategories = ['internal->internal', 'external->internal', 'internal->external'];
        
        if (!in_array($kategori, $validCategories)) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak valid'], 400);
        }

        $agenda = Agenda::byCategory($kategori)->get();
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
            'keperluan'         => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        $kunjungan = Kunjungan::create($validated);
        return response()->json(['message' => 'Data kunjungan berhasil dikelola', 'data' => $kunjungan]);
    }

    // + cetak_Laporan()
    public function cetak_Laporan()
    {
        $logbook = Logbook::all();
        return response()->json(['message' => 'Laporan logbook berhasil ditarik', 'data' => $logbook]);
    }
}
