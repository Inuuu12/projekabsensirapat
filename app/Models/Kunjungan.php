<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_kunjungan';
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'nama_pegawai',
        'nama_pejabat',
        'nama_pengunjung',
        'asal_instansi',
        'nomorhp_pengunjung',
        'email_pengunjung',
        'keperluan',
        'waktu',
        'tanggal_kunjungan',
        'id_admin',
        'id_dinas',
        'id_kecamatan',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('dinas_kecamatan', function (Builder $builder) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                $table = $builder->getQuery()->from;
                if ($user->role === 'admin_dinas' && $user->id_dinas && \Illuminate\Support\Facades\Schema::hasColumn($table, 'id_dinas')) {
                    $builder->where($table . '.id_dinas', $user->id_dinas);
                } elseif ($user->role === 'admin_kecamatan' && $user->id_kecamatan && \Illuminate\Support\Facades\Schema::hasColumn($table, 'id_kecamatan')) {
                    $builder->where($table . '.id_kecamatan', $user->id_kecamatan);
                }
            }
        });

        static::creating(function ($model) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                if ($user->role === 'admin_dinas' && $user->id_dinas && \Illuminate\Support\Facades\Schema::hasColumn('sirapi_md_kunjungan', 'id_dinas')) {
                    $model->id_dinas = $user->id_dinas;
                } elseif ($user->role === 'admin_kecamatan' && $user->id_kecamatan && \Illuminate\Support\Facades\Schema::hasColumn('sirapi_md_kunjungan', 'id_kecamatan')) {
                    $model->id_kecamatan = $user->id_kecamatan;
                }
            }
        });
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function getNamaPegawaiAttribute($value)
    {
        return $value ?? $this->attributes['nama_pejabat'] ?? null;
    }

    public function getNamaPejabatAttribute($value)
    {
        return $value ?? $this->attributes['nama_pegawai'] ?? null;
    }
}
