<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangRapat extends Model
{
    use HasFactory;

    protected $table = 'ruang_rapat';
    protected $primaryKey = 'id_ruangrapat';
    protected $fillable = ['nama_ruang'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_ruangrapat', 'id_ruangrapat');
    }

    public function tersedia(?string $tanggal = null, ?string $jadwal = null): bool
    {
        return ! $this->agendas()
            ->when($tanggal, fn ($query) => $query->whereDate('tanggal', $tanggal))
            ->when($jadwal, fn ($query) => $query->where('jadwal', $jadwal))
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->exists();
    }
}
