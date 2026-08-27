<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangRapat extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_ruangrapat';
    protected $primaryKey = 'id_ruangrapat';
    protected $fillable = ['nama_ruang', 'kapasitas', 'status', 'keterangan'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_ruangrapat', 'id_ruangrapat');
    }

    public function getDynamicStatusAttribute(): string
    {
        if (($this->status ?? 'tersedia') === 'terpakai') {
            return 'terpakai';
        }

        return $this->isCurrentlyOccupied() ? 'terpakai' : 'tersedia';
    }

    public function isCurrentlyOccupied(): bool
    {
        return $this->currentActiveAgenda() !== null;
    }

    public function currentActiveAgenda(): ?Agenda
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $now = Carbon::now($timezone);
        $todayAgendas = $this->agendas()
            ->whereDate('tanggal', $now->toDateString())
            ->get();

        foreach ($todayAgendas as $agenda) {
            $date = $agenda->tanggal instanceof Carbon ? $agenda->tanggal->toDateString() : (string) $agenda->tanggal;
            $startTime = substr((string) $agenda->waktu, 0, 5) ?: '00:00';
            $endTime = substr((string) $agenda->waktu_selesai, 0, 5);

            $start = Carbon::parse($date . ' ' . $startTime, $timezone);
            $end = $endTime
                ? Carbon::parse($date . ' ' . $endTime, $timezone)
                : $start->copy()->addHour();

            if ($end->lessThanOrEqualTo($start)) {
                $end->addDay();
            }

            if ($now->betweenIncluded($start, $end)) {
                return $agenda;
            }
        }

        return null;
    }

    public function checkConflict(string $tanggal, string $waktuMulai, ?string $waktuSelesai = null, ?int $ignoreAgendaId = null): ?Agenda
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $targetStart = Carbon::parse($tanggal . ' ' . substr($waktuMulai, 0, 5), $timezone);
        $targetEnd = !empty($waktuSelesai)
            ? Carbon::parse($tanggal . ' ' . substr($waktuSelesai, 0, 5), $timezone)
            : $targetStart->copy()->addHour();

        if ($targetEnd->lessThanOrEqualTo($targetStart)) {
            $targetEnd->addDay();
        }

        $agendas = $this->agendas()
            ->whereDate('tanggal', $tanggal)
            ->when($ignoreAgendaId, fn ($q) => $q->where('id_agenda', '!=', $ignoreAgendaId))
            ->get();

        foreach ($agendas as $existing) {
            $existDate = $existing->tanggal instanceof Carbon ? $existing->tanggal->toDateString() : (string) $existing->tanggal;
            $existStartTime = substr((string) $existing->waktu, 0, 5) ?: '00:00';
            $existEndTime = substr((string) $existing->waktu_selesai, 0, 5);

            $existStart = Carbon::parse($existDate . ' ' . $existStartTime, $timezone);
            $existEnd = $existEndTime
                ? Carbon::parse($existDate . ' ' . $existEndTime, $timezone)
                : $existStart->copy()->addHour();

            if ($existEnd->lessThanOrEqualTo($existStart)) {
                $existEnd->addDay();
            }

            // Overlap formula: startA < endB && endA > startB
            if ($targetStart->lt($existEnd) && $targetEnd->gt($existStart)) {
                return $existing;
            }
        }

        return null;
    }
}
