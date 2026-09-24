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
        static::addGlobalScope('instansi', function (Builder $builder) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                $table = $builder->getQuery()->from;

                // 1. Admin Dinas: Hanya tampilkan aduan yang ditujukan ke dinasnya
                if (in_array($user->role, ['admin_dinas', 'dinas']) && $user->id_dinas) {
                    if ((int) $user->id_dinas === 1) {
                        $builder->where(function ($q) use ($table, $user) {
                            $q->where($table . '.id_dinas', $user->id_dinas)
                              ->orWhereNull($table . '.id_dinas');
                        });
                    } else {
                        $builder->where($table . '.id_dinas', $user->id_dinas);
                    }
                }
                // 2. Admin Kecamatan: Karena aduan publik saat ini khusus ditujukan ke Dinas / SKPD,
                // admin kecamatan tidak melihat aduan milik dinas lain.
                elseif (in_array($user->role, ['admin_kecamatan', 'kecamatan'])) {
                    $builder->whereRaw('1 = 0');
                }
                // 3. Super Admin: Tetap melihat seluruh aduan
            }
        });

        static::creating(function ($model) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                if (in_array($user->role, ['admin_dinas', 'dinas']) && $user->id_dinas) {
                    $model->id_dinas = $user->id_dinas;
                }
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
