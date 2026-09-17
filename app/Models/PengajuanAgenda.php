<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanAgenda extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_pengajuan_agenda';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_pegawai',
        'nama_agenda',
        'kategori_surat',
        'tanggal',
        'waktu',
        'waktu_selesai',
        'id_ruangrapat',
        'penyelenggara',
        'ditugaskan',
        'kuota',
        'deskripsi',
        'lampiran',
        'status',
        'catatan_admin',
        'id_dinas',
        'id_kecamatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('instansi', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                $table = $builder->getQuery()->from;
                $hasDinas = \Illuminate\Support\Facades\Schema::hasColumn($table, 'id_dinas');
                $hasKecamatan = \Illuminate\Support\Facades\Schema::hasColumn($table, 'id_kecamatan');

                if (in_array($user->role, ['admin_dinas', 'dinas']) && $user->id_dinas && $hasDinas) {
                    $builder->where($table . '.id_dinas', $user->id_dinas);
                } elseif (in_array($user->role, ['admin_kecamatan', 'kecamatan']) && $user->id_kecamatan && $hasKecamatan) {
                    $builder->where($table . '.id_kecamatan', $user->id_kecamatan);
                }
            }
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function ruangRapat()
    {
        return $this->belongsTo(RuangRapat::class, 'id_ruangrapat', 'id_ruangrapat');
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }
}
