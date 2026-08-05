<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'sirapi_md_pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'foto',
        'nama_pegawai',    
        'nip',
        'tanggal_lahir',
        'jabatan',
        'bidang',
        'nomor_hp',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];

    public function getNamaAttribute(): ?string
    {
        return $this->nama_pegawai;
    }

    public function getTanggalAttribute(): mixed
    {
        return $this->tanggal_lahir;
    }

    public function getGambarAttribute(): ?string
    {
        return $this->foto;
    }

    public static function ulangTahunPegawai()
    {
        $today = Carbon::today('Asia/Jakarta');

        return self::query()
            ->whereNotNull('tanggal_lahir')
            ->get()
            ->sortBy(function (self $pegawai) use ($today) {
                $tanggalLahir = $pegawai->tanggal_lahir;

                if (! $tanggalLahir) {
                    return PHP_INT_MAX;
                }

                $nextBirthday = $tanggalLahir->copy()->year($today->year);

                if ($nextBirthday->lt($today)) {
                    $nextBirthday->addYear();
                }

                return $nextBirthday->timestamp;
            })
            ->values();
    }
}
