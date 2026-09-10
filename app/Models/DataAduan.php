<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DataAduan extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_dataaduan';
    protected $primaryKey = 'id_dataaduan';

    protected $fillable = [
        'nama_pengadu',
        'nomor_pengadu',
        'email',
        'foto',
        'isi_aduan',
        'balasan_admin',
        'status',
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

    public static function kelolaAduan()
    {
        return self::latest('id_dataaduan')->get();
    }
}
