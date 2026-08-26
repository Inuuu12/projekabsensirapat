<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable;

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_PENDING = 'pending';
    public const STATUS_DITOLAK = 'ditolak';

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
        'status_verifikasi',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];

    public function isAktif(): bool
    {
        return ($this->status_verifikasi ?? self::STATUS_AKTIF) === self::STATUS_AKTIF;
    }

    public function isPending(): bool
    {
        return $this->status_verifikasi === self::STATUS_PENDING;
    }

    public function isDitolak(): bool
    {
        return $this->status_verifikasi === self::STATUS_DITOLAK;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_verifikasi) {
            self::STATUS_PENDING => 'Menunggu Verifikasi',
            self::STATUS_DITOLAK => 'Ditolak',
            default => 'Aktif',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_verifikasi) {
            self::STATUS_PENDING => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-700/50',
            self::STATUS_DITOLAK => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/60 dark:text-red-300 dark:border-red-700/50',
            default => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-700/50',
        };
    }

    public function scopeAktif($query)
    {
        return $query->where('status_verifikasi', self::STATUS_AKTIF);
    }

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', self::STATUS_PENDING);
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', self::STATUS_DITOLAK);
    }

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
