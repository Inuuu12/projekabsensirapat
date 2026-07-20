<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Cuaca;
use App\Models\DokumenNotulen;
use App\Models\FaceRecog;
use App\Models\Galeri;
use App\Models\Kehadiran;
use App\Models\Kunjungan;
use App\Models\Logbook;
use App\Models\Masukan;
use App\Models\Pegawai;
use App\Models\Peserta;
use App\Models\QRCode;
use App\Models\RuangRapat;
use App\Models\StatusAgenda;
use App\Models\StatusMasukan;
use App\Models\UlangTahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminCrudController extends Controller
{
    public function index(Request $request, string $resource)
    {
        $config = $this->config($resource);
        $model = $config['model'];
        $keyword = $request->query('keyword');
        $query = $model::query();

        if ($keyword && ! empty($config['search'])) {
            $query->where(function ($search) use ($config, $keyword) {
                foreach ($config['search'] as $field) {
                    $search->orWhere($field, 'like', "%{$keyword}%");
                }
            });
        }

        foreach ($config['with'] ?? [] as $relation) {
            $query->with($relation);
        }

        $items = $query->latest($config['sort'] ?? $config['key'])->paginate(10)->withQueryString();
        $editItem = $request->filled('edit') ? $model::find($request->query('edit')) : null;

        return view('admin.crud', [
            'resource' => $resource,
            'config' => $config,
            'items' => $items,
            'editItem' => $editItem,
        ]);
    }

    public function store(Request $request, string $resource)
    {
        $config = $this->config($resource);
        $data = $this->validated($request, $config);
        $this->beforeSave($resource, $data);

        $config['model']::create($data);

        return back()->with('success', "{$config['title']} berhasil ditambahkan.");
    }

    public function update(Request $request, string $resource, int $id)
    {
        $config = $this->config($resource);
        $item = $config['model']::findOrFail($id);
        $data = $this->validated($request, $config, $item);
        $this->beforeSave($resource, $data);

        $item->update($data);

        return redirect()->route('admin.crud.index', $resource)->with('success', "{$config['title']} berhasil diperbarui.");
    }

    public function destroy(string $resource, int $id)
    {
        $config = $this->config($resource);
        $config['model']::findOrFail($id)->delete();

        return back()->with('success', "{$config['title']} berhasil dihapus.");
    }

    private function validated(Request $request, array $config, mixed $item = null): array
    {
        $rules = $config['rules'];

        if (($config['model'] ?? null) === Admin::class) {
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($item?->id_admin, 'id_admin')];
            $rules['password'] = $item ? ['nullable', 'string', 'min:6'] : ['required', 'string', 'min:6'];
        }

        $data = $request->validate($rules);

        if (($config['model'] ?? null) === Admin::class && empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    private function beforeSave(string $resource, array &$data): void
    {
        if ($resource === 'agenda') {
            $status = StatusAgenda::find($data['id_statusAgenda'] ?? null);
            $room = RuangRapat::find($data['id_ruangrapat'] ?? null);

            $data['id_admin'] = Auth::guard('admin')->id();
            $data['status'] = $status?->nama_status ?? 'Akan Datang';
            $data['tempat'] = $data['tempat'] ?: $room?->nama_ruang;
        }

        if (in_array($resource, ['masukan', 'data-masukan'], true)) {
            $status = StatusMasukan::find($data['id_statusMasukan'] ?? null);

            $data['id_admin'] = Auth::guard('admin')->id();
            $data['status'] = $status?->nama_status ?? 'Menunggu';
        }

        if ($resource === 'kunjungan') {
            $data['id_admin'] = Auth::guard('admin')->id();
        }
    }

    private function config(string $resource): array
    {
        $configs = [
            'admins' => [
                'title' => 'Admin',
                'model' => Admin::class,
                'key' => 'id_admin',
                'search' => ['nama', 'email'],
                'fields' => [
                    ['name' => 'nama', 'label' => 'Nama'],
                    ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
                    ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'hideTable' => true],
                ],
                'rules' => ['nama' => ['required', 'string', 'max:255']],
            ],
            'status-agenda' => [
                'title' => 'Status Agenda',
                'model' => StatusAgenda::class,
                'key' => 'id_statusAgenda',
                'search' => ['nama_status'],
                'fields' => [['name' => 'nama_status', 'label' => 'Nama Status']],
                'rules' => ['nama_status' => ['required', 'string', 'max:255']],
            ],
            'status-masukan' => [
                'title' => 'Status Masukan',
                'model' => StatusMasukan::class,
                'key' => 'id_statusMasukan',
                'search' => ['nama_status'],
                'fields' => [['name' => 'nama_status', 'label' => 'Nama Status']],
                'rules' => ['nama_status' => ['required', 'string', 'max:255']],
            ],
            'pegawai' => [
                'title' => 'Pegawai',
                'model' => Pegawai::class,
                'key' => 'id_pegawai',
                'search' => ['nip', 'nama', 'jabatan', 'nomor_hp'],
                'fields' => [
                    ['name' => 'nip', 'label' => 'NIP'],
                    ['name' => 'nama', 'label' => 'Nama'],
                    ['name' => 'jabatan', 'label' => 'Jabatan', 'required' => false],
                    ['name' => 'nomor_hp', 'label' => 'Nomor HP', 'required' => false],
                ],
                'rules' => [
                    'nip' => ['required', 'string', 'max:50'],
                    'nama' => ['required', 'string', 'max:255'],
                    'jabatan' => ['nullable', 'string', 'max:255'],
                    'nomor_hp' => ['nullable', 'string', 'max:30'],
                ],
            ],
            'ruang-rapat' => [
                'title' => 'Ruang Rapat',
                'model' => RuangRapat::class,
                'key' => 'id_ruangrapat',
                'search' => ['nama_ruang'],
                'fields' => [['name' => 'nama_ruang', 'label' => 'Nama Ruang']],
                'rules' => ['nama_ruang' => ['required', 'string', 'max:255']],
            ],
            'agenda' => [
                'title' => 'Agenda',
                'model' => Agenda::class,
                'key' => 'id_agenda',
                'search' => ['tempat', 'status', 'link_url'],
                'sort' => 'jadwal',
                'with' => ['statusAgenda', 'ruang'],
                'fields' => [
                    ['name' => 'id_statusAgenda', 'label' => 'Status Agenda', 'type' => 'select', 'options' => StatusAgenda::pluck('nama_status', 'id_statusAgenda')->all()],
                    ['name' => 'id_ruangrapat', 'label' => 'Ruang Rapat', 'type' => 'select', 'required' => false, 'options' => RuangRapat::pluck('nama_ruang', 'id_ruangrapat')->all()],
                    ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'date'],
                    ['name' => 'tempat', 'label' => 'Tempat', 'required' => false],
                    ['name' => 'kapasitas', 'label' => 'Kapasitas', 'type' => 'number'],
                    ['name' => 'jadwal', 'label' => 'Jadwal', 'type' => 'datetime-local'],
                    ['name' => 'link_url', 'label' => 'Link URL', 'required' => false],
                ],
                'rules' => [
                    'id_statusAgenda' => ['required', 'exists:status_agenda,id_statusAgenda'],
                    'id_ruangrapat' => ['nullable', 'exists:ruang_rapat,id_ruangrapat'],
                    'tanggal' => ['required', 'date'],
                    'tempat' => ['nullable', 'string', 'max:255'],
                    'kapasitas' => ['required', 'integer', 'min:0'],
                    'jadwal' => ['required', 'date'],
                    'link_url' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'qrcode' => [
                'title' => 'QRCode',
                'model' => QRCode::class,
                'key' => 'id_qrcode',
                'search' => ['qr_code_path'],
                'with' => ['agenda'],
                'fields' => [
                    ['name' => 'id_agenda', 'label' => 'Agenda', 'type' => 'select', 'options' => Agenda::pluck('jadwal', 'id_agenda')->all()],
                    ['name' => 'qr_code_path', 'label' => 'QR Code Path'],
                ],
                'rules' => [
                    'id_agenda' => ['required', 'exists:agenda,id_agenda'],
                    'qr_code_path' => ['required', 'string', 'max:255'],
                ],
            ],
            'peserta' => [
                'title' => 'Peserta',
                'model' => Peserta::class,
                'key' => 'id_peserta',
                'search' => ['nama', 'jabatan', 'instansi', 'jenis_peserta'],
                'fields' => [
                    ['name' => 'nama', 'label' => 'Nama'],
                    ['name' => 'jabatan', 'label' => 'Jabatan', 'required' => false],
                    ['name' => 'instansi', 'label' => 'Instansi', 'required' => false],
                    ['name' => 'jenis_peserta', 'label' => 'Jenis Peserta', 'type' => 'select', 'options' => ['pegawai' => 'Pegawai', 'tamu_internal' => 'Tamu Internal', 'tamu_eksternal' => 'Tamu Eksternal']],
                ],
                'rules' => [
                    'nama' => ['required', 'string', 'max:255'],
                    'jabatan' => ['nullable', 'string', 'max:255'],
                    'instansi' => ['nullable', 'string', 'max:255'],
                    'jenis_peserta' => ['required', 'in:pegawai,tamu_internal,tamu_eksternal'],
                ],
            ],
            'kehadiran' => [
                'title' => 'Kehadiran',
                'model' => Kehadiran::class,
                'key' => 'id_kehadiran',
                'search' => ['metode', 'status', 'catatan'],
                'sort' => 'waktu_hadir',
                'fields' => [
                    ['name' => 'id_agenda', 'label' => 'Agenda', 'type' => 'select', 'options' => Agenda::pluck('jadwal', 'id_agenda')->all()],
                    ['name' => 'id_peserta', 'label' => 'Peserta', 'type' => 'select', 'required' => false, 'options' => Peserta::pluck('nama', 'id_peserta')->all()],
                    ['name' => 'id_qrcode', 'label' => 'QRCode', 'type' => 'select', 'required' => false, 'options' => QRCode::pluck('qr_code_path', 'id_qrcode')->all()],
                    ['name' => 'metode', 'label' => 'Metode', 'type' => 'select', 'options' => ['qr' => 'QR', 'facerecog' => 'FaceRecog', 'manual' => 'Manual']],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['hadir' => 'Hadir', 'izin' => 'Izin', 'tidak_hadir' => 'Tidak Hadir']],
                    ['name' => 'waktu_hadir', 'label' => 'Waktu Hadir', 'type' => 'datetime-local', 'required' => false],
                    ['name' => 'catatan', 'label' => 'Catatan', 'type' => 'textarea', 'required' => false],
                ],
                'rules' => [
                    'id_agenda' => ['required', 'exists:agenda,id_agenda'],
                    'id_peserta' => ['nullable', 'exists:peserta,id_peserta'],
                    'id_qrcode' => ['nullable', 'exists:qrcodes,id_qrcode'],
                    'metode' => ['required', 'in:qr,facerecog,manual'],
                    'status' => ['required', 'in:hadir,izin,tidak_hadir'],
                    'waktu_hadir' => ['nullable', 'date'],
                    'catatan' => ['nullable', 'string'],
                ],
            ],
            'face-recog' => [
                'title' => 'FaceRecog',
                'model' => FaceRecog::class,
                'key' => 'id_facerecog',
                'search' => ['id_peserta'],
                'fields' => [
                    ['name' => 'id_peserta', 'label' => 'Peserta', 'type' => 'select', 'options' => Peserta::pluck('nama', 'id_peserta')->all()],
                    ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'select', 'options' => [1 => 'Aktif', 0 => 'Nonaktif']],
                ],
                'rules' => [
                    'id_peserta' => ['required', 'exists:peserta,id_peserta'],
                    'aktif' => ['required', 'boolean'],
                ],
            ],
            'masukan' => $this->masukanConfig('Masukan'),
            'data-masukan' => $this->masukanConfig('Data Masukan'),
            'berita' => [
                'title' => 'Berita',
                'model' => Berita::class,
                'key' => 'id_berita',
                'search' => ['judul', 'isiBerita', 'sumber'],
                'sort' => 'tanggal',
                'fields' => [
                    ['name' => 'judul', 'label' => 'Judul'],
                    ['name' => 'isiBerita', 'label' => 'Isi Berita', 'type' => 'textarea', 'required' => false],
                    ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'date', 'required' => false],
                    ['name' => 'gambar', 'label' => 'Gambar', 'required' => false],
                    ['name' => 'sumber', 'label' => 'Sumber', 'required' => false],
                ],
                'rules' => [
                    'judul' => ['required', 'string', 'max:255'],
                    'isiBerita' => ['nullable', 'string'],
                    'tanggal' => ['nullable', 'date'],
                    'gambar' => ['nullable', 'string', 'max:255'],
                    'sumber' => ['nullable', 'string', 'max:255'],
                ],
            ],
            'galeri' => [
                'title' => 'Galeri',
                'model' => Galeri::class,
                'key' => 'id_galeri',
                'search' => ['foto', 'keterangan'],
                'fields' => [
                    ['name' => 'foto', 'label' => 'Foto'],
                    ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'required' => false],
                ],
                'rules' => [
                    'foto' => ['required', 'string', 'max:255'],
                    'keterangan' => ['nullable', 'string'],
                ],
            ],
            'ulang-tahun' => [
                'title' => 'Ulang Tahun',
                'model' => UlangTahun::class,
                'key' => 'id_ulangtahun',
                'search' => ['nama'],
                'sort' => 'tanggal',
                'fields' => [
                    ['name' => 'nama', 'label' => 'Nama'],
                    ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'date'],
                ],
                'rules' => [
                    'nama' => ['required', 'string', 'max:255'],
                    'tanggal' => ['required', 'date'],
                ],
            ],
            'cuaca' => [
                'title' => 'Cuaca',
                'model' => Cuaca::class,
                'key' => 'id_cuaca',
                'search' => ['lokasi', 'kondisi'],
                'fields' => [
                    ['name' => 'lokasi', 'label' => 'Lokasi'],
                    ['name' => 'suhu', 'label' => 'Suhu', 'type' => 'number', 'required' => false],
                    ['name' => 'kondisi', 'label' => 'Kondisi', 'required' => false],
                    ['name' => 'kelembapan', 'label' => 'Kelembapan', 'type' => 'number', 'required' => false],
                ],
                'rules' => [
                    'lokasi' => ['required', 'string', 'max:255'],
                    'suhu' => ['nullable', 'numeric'],
                    'kondisi' => ['nullable', 'string', 'max:255'],
                    'kelembapan' => ['nullable', 'integer', 'min:0', 'max:100'],
                ],
            ],
            'logbook' => [
                'title' => 'Logbook',
                'model' => Logbook::class,
                'key' => 'id_log',
                'search' => ['aktivitas'],
                'sort' => 'waktu',
                'fields' => [
                    ['name' => 'id_admin', 'label' => 'Admin', 'type' => 'select', 'required' => false, 'options' => Admin::pluck('nama', 'id_admin')->all()],
                    ['name' => 'aktivitas', 'label' => 'Aktivitas', 'required' => false],
                    ['name' => 'waktu', 'label' => 'Waktu', 'type' => 'datetime-local'],
                ],
                'rules' => [
                    'id_admin' => ['nullable', 'exists:admins,id_admin'],
                    'aktivitas' => ['nullable', 'string', 'max:255'],
                    'waktu' => ['required', 'date'],
                ],
            ],
            'dokumen-notulen' => [
                'title' => 'Dokumen Notulen',
                'model' => DokumenNotulen::class,
                'key' => 'id_dokumen',
                'search' => ['namaFile', 'filePath'],
                'fields' => [
                    ['name' => 'id_agenda', 'label' => 'Agenda', 'type' => 'select', 'required' => false, 'options' => Agenda::pluck('jadwal', 'id_agenda')->all()],
                    ['name' => 'namaFile', 'label' => 'Nama File'],
                    ['name' => 'filePath', 'label' => 'File Path'],
                ],
                'rules' => [
                    'id_agenda' => ['nullable', 'exists:agenda,id_agenda'],
                    'namaFile' => ['required', 'string', 'max:255'],
                    'filePath' => ['required', 'string', 'max:255'],
                ],
            ],
            'kunjungan' => [
                'title' => 'Kunjungan',
                'model' => Kunjungan::class,
                'key' => 'id_kunjungan',
                'search' => ['nama', 'instansi', 'nomor_hp'],
                'sort' => 'tanggal_kunjungan',
                'fields' => [
                    ['name' => 'nama', 'label' => 'Nama'],
                    ['name' => 'instansi', 'label' => 'Instansi', 'required' => false],
                    ['name' => 'nomor_hp', 'label' => 'Nomor HP', 'required' => false],
                    ['name' => 'foto_selfie', 'label' => 'Foto Selfie', 'required' => false],
                    ['name' => 'tanggal_kunjungan', 'label' => 'Tanggal Kunjungan', 'type' => 'date'],
                ],
                'rules' => [
                    'nama' => ['required', 'string', 'max:255'],
                    'instansi' => ['nullable', 'string', 'max:255'],
                    'nomor_hp' => ['nullable', 'string', 'max:30'],
                    'foto_selfie' => ['nullable', 'string', 'max:255'],
                    'tanggal_kunjungan' => ['required', 'date'],
                ],
            ],
        ];

        abort_unless(isset($configs[$resource]), 404);

        return $configs[$resource];
    }

    private function masukanConfig(string $title): array
    {
        return [
            'title' => $title,
            'model' => Masukan::class,
            'key' => 'id_masukan',
            'search' => ['nama_pengadu', 'email', 'isi_masukan', 'status'],
            'sort' => 'created_at',
            'with' => ['statusMasukan'],
            'fields' => [
                ['name' => 'id_statusMasukan', 'label' => 'Status Masukan', 'type' => 'select', 'options' => StatusMasukan::pluck('nama_status', 'id_statusMasukan')->all()],
                ['name' => 'nama_pengadu', 'label' => 'Nama Pengadu', 'required' => false],
                ['name' => 'no_hp', 'label' => 'No HP', 'required' => false],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => false],
                ['name' => 'isi_masukan', 'label' => 'Isi Masukan', 'type' => 'textarea'],
                ['name' => 'lampiran', 'label' => 'Lampiran', 'required' => false],
                ['name' => 'balasan_admin', 'label' => 'Balasan Admin', 'type' => 'textarea', 'required' => false],
                ['name' => 'waktu_proses', 'label' => 'Waktu Proses', 'type' => 'datetime-local', 'required' => false],
                ['name' => 'waktu_selesai', 'label' => 'Waktu Selesai', 'type' => 'datetime-local', 'required' => false],
                ['name' => 'verified_at', 'label' => 'Verified At', 'type' => 'datetime-local', 'required' => false],
            ],
            'rules' => [
                'id_statusMasukan' => ['required', 'exists:status_masukan,id_statusMasukan'],
                'nama_pengadu' => ['nullable', 'string', 'max:255'],
                'no_hp' => ['nullable', 'string', 'max:30'],
                'email' => ['nullable', 'email', 'max:255'],
                'isi_masukan' => ['required', 'string'],
                'lampiran' => ['nullable', 'string', 'max:255'],
                'balasan_admin' => ['nullable', 'string'],
                'waktu_proses' => ['nullable', 'date'],
                'waktu_selesai' => ['nullable', 'date'],
                'verified_at' => ['nullable', 'date'],
            ],
        ];
    }
}
