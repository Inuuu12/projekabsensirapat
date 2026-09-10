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
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('dinas', function (Builder $builder) {
            if (auth('admin')->check() && auth('admin')->user()->role === 'admin_dinas') {
                $builder->where($builder->getQuery()->from . '.id_dinas', auth('admin')->user()->id_dinas);
            }
        });

        static::creating(function ($model) {
            if (auth('admin')->check() && auth('admin')->user()->role === 'admin_dinas') {
                $model->id_dinas = auth('admin')->user()->id_dinas;
            }
        });
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
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
