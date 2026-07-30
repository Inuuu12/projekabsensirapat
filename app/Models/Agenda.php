<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    public const STATUS_MENDATANG = 'Mendatang';
    public const STATUS_BERLANGSUNG = 'Berlangsung';
    public const STATUS_SELESAI = 'Selesai';

    protected $table = 'app_md_agenda';
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

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_label) {
            self::STATUS_MENDATANG => 'bg-blue-50 text-blue-700 border-blue-100',
            self::STATUS_BERLANGSUNG => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            self::STATUS_SELESAI => 'bg-gray-100 text-gray-600 border-gray-200',
            default => 'bg-[#35635b]/10 text-[#35635b] border-[#35635b]/10',
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
}
