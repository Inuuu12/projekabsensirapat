<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agenda extends Model
{
    use HasFactory;

    public const STATUS_MENDATANG = 'Mendatang';
    public const STATUS_BERLANGSUNG = 'Berlangsung';
    public const STATUS_SELESAI = 'Selesai';

    protected $table = 'sirapi_md_agenda';
    protected $primaryKey = 'id_agenda';

    protected $fillable = [
        'nama_agenda',
        'kategori_surat',
        'asal_surat',
        'ditugaskan',
        'lampiran',
        'tanggal',
        'waktu',
        'waktu_selesai',
        'kuota',
        'lokasi',
        'status_fr',
        'status_qr',
        'id_ruangrapat',
        'id_statusagenda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'status_fr' => 'boolean',
        ];
    }

    public function statusAgenda()
    {
        return $this->belongsTo(StatusAgenda::class, 'id_statusagenda', 'id_statusagenda');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::resolveStatusLabel($this->tanggal, $this->waktu, $this->waktu_selesai);
    }

    public function isMendatang(): bool
    {
        return $this->status_label === self::STATUS_MENDATANG;
    }

    public function isBerlangsung(): bool
    {
        return $this->status_label === self::STATUS_BERLANGSUNG;
    }

    public function isSelesai(): bool
    {
        return $this->status_label === self::STATUS_SELESAI;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_label) {
            self::STATUS_MENDATANG => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-700/50',
            self::STATUS_BERLANGSUNG => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-700/50',
            self::STATUS_SELESAI => 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-[#1a2e29] dark:text-slate-200 dark:border-[#35584f]',
            default => 'bg-[#35635b]/10 text-[#35635b] border-[#35635b]/20 dark:bg-[#1a332d] dark:text-emerald-300 dark:border-emerald-500/30',
        };
    }

    public static function resolveStatusLabel(mixed $tanggal, mixed $waktu, mixed $waktuSelesai = null): string
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $date = $tanggal instanceof Carbon ? $tanggal->toDateString() : (string) $tanggal;
        $startTime = substr((string) $waktu, 0, 5) ?: '00:00';
        $endTime = substr((string) $waktuSelesai, 0, 5);

        $start = Carbon::parse($date . ' ' . $startTime, $timezone);
        $end = $endTime
            ? Carbon::parse($date . ' ' . $endTime, $timezone)
            : $start->copy()->addHour();

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $now = Carbon::now($timezone);

        if ($now->lt($start)) {
            return self::STATUS_MENDATANG;
        }

        if ($now->betweenIncluded($start, $end)) {
            return self::STATUS_BERLANGSUNG;
        }

        return self::STATUS_SELESAI;
    }

    public function canPegawaiPresensi(mixed $pegawai): bool
    {
        // Jika bukan agenda surat masuk, tidak dibatasi penugasan khusus
        if (strtolower((string) ($this->kategori_surat ?? '')) !== 'masuk') {
            return true;
        }

        // Jika agenda surat masuk tetapi kolom ditugaskan kosong / tidak diisi, izinkan semua pegawai
        $ditugaskanStr = trim((string) ($this->ditugaskan ?? ''));
        if ($ditugaskanStr === '' || $ditugaskanStr === '-') {
            return true;
        }

        if (! $pegawai) {
            return false;
        }

        $namaPegawai = is_object($pegawai) ? ($pegawai->nama_pegawai ?? $pegawai->nama ?? '') : (string) $pegawai;
        $nipPegawai = is_object($pegawai) ? ($pegawai->nip ?? '') : '';

        // Pecah daftar nama pegawai yang ditugaskan (dipisahkan koma atau titik koma)
        $assignedList = array_filter(array_map(
            fn ($item) => strtolower(trim($item)),
            preg_split('/[,;]+/', $ditugaskanStr)
        ));

        $targetName = strtolower(trim((string) $namaPegawai));
        $targetNip = strtolower(trim((string) $nipPegawai));

        if ($targetName === '' && $targetNip === '') {
            return false;
        }

        foreach ($assignedList as $assigned) {
            if ($assigned === '') continue;

            // 1. Cocokkan NIP jika ada
            if ($targetNip !== '' && ($assigned === $targetNip || str_contains($assigned, $targetNip))) {
                return true;
            }

            // 2. Cocokkan nama persis atau substring
            if ($targetName !== '') {
                if ($assigned === $targetName || str_contains($targetName, $assigned) || str_contains($assigned, $targetName)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function totalPesertaHadir(): int
    {
        $kehadiranCount = DB::table('sirapi_md_kehadiran')->where('id_agenda', $this->id_agenda)->count();
        $tamuCount = DB::table('sirapi_md_tamu')->where('id_agenda', $this->id_agenda)->count();

        return $kehadiranCount + $tamuCount;
    }

    public function isKuotaPenuh(): bool
    {
        if (strtolower((string) ($this->kategori_surat ?? '')) === 'masuk') {
            return false;
        }

        $kuota = (int) ($this->kuota ?? 0);
        if ($kuota <= 0) {
            return false;
        }

        return $this->totalPesertaHadir() >= $kuota;
    }

    public function isPegawaiSudahHadir(mixed $pegawai): bool
    {
        if (! $pegawai) {
            return false;
        }

        $email = is_object($pegawai) ? ($pegawai->email ?? '') : (string) $pegawai;
        if (! $email) {
            return false;
        }

        return DB::table('sirapi_md_kehadiran')
            ->join('sirapi_md_peserta', 'sirapi_md_kehadiran.id_peserta', '=', 'sirapi_md_peserta.id_peserta')
            ->where('sirapi_md_kehadiran.id_agenda', $this->id_agenda)
            ->where('sirapi_md_peserta.email', $email)
            ->exists();
    }
}
