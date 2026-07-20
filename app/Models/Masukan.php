<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masukan extends Model
{
    use HasFactory;

    protected $table = 'masukan';
    protected $primaryKey = 'id_masukan';
    protected $fillable = [
        'id_admin',
        'id_statusMasukan',
        'nama_pengadu',
        'no_hp',
        'email',
        'isi_masukan',
        'lampiran',
        'status',
        'balasan_admin',
        'waktu_proses',
        'waktu_selesai',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'waktu_proses' => 'datetime',
            'waktu_selesai' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function statusMasukan()
    {
        return $this->belongsTo(StatusMasukan::class, 'id_statusMasukan', 'id_statusMasukan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public static function kirimMasukan(array $data): self
    {
        $status = StatusMasukan::where('nama_status', 'Menunggu')->first();

        return self::create($data + [
            'id_statusMasukan' => $status?->id_statusMasukan ?? 1,
            'status' => $status?->nama_status ?? 'Menunggu',
        ]);
    }

    public static function cekStatusMasukan(int $idMasukan): ?string
    {
        return self::with('statusMasukan')->find($idMasukan)?->statusMasukan?->nama_status;
    }
}
