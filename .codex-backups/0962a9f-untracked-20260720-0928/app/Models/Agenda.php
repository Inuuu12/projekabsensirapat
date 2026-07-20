<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';
    protected $primaryKey = 'id_agenda';
    protected $fillable = [
        'id_admin',
        'id_statusAgenda',
        'id_ruangrapat',
        'tanggal',
        'tempat',
        'kapasitas',
        'status',
        'jadwal',
        'link_url',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jadwal' => 'datetime',
        ];
    }

    public function statusAgenda()
    {
        return $this->belongsTo(StatusAgenda::class, 'id_statusAgenda', 'id_statusAgenda');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function ruang()
    {
        return $this->belongsTo(RuangRapat::class, 'id_ruangrapat', 'id_ruangrapat');
    }

    public function qrcode()
    {
        return $this->hasOne(QRCode::class, 'id_agenda', 'id_agenda');
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'agenda_peserta', 'id_agenda', 'id_peserta')
            ->withTimestamps();
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_agenda', 'id_agenda');
    }

    public function dokumenNotulen()
    {
        return $this->hasMany(DokumenNotulen::class, 'id_agenda', 'id_agenda');
    }

    public static function tambahAgenda(array $data): self
    {
        return self::create($data);
    }

    public function editAgenda(array $data): bool
    {
        return $this->update($data);
    }

    public function hapusAgenda(): ?bool
    {
        return $this->delete();
    }

    public function lihatDetail(): self
    {
        return $this->load(['statusAgenda', 'ruang', 'qrcode', 'peserta', 'kehadiran']);
    }

    public function konfigurasiQRCode(): QRCode
    {
        return QRCode::generateQR($this->id_agenda);
    }
}
