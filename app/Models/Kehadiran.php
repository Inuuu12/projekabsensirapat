<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';
    protected $fillable = [
        'id_agenda',
        'id_peserta',
        'id_qrcode',
        'metode',
        'status',
        'waktu_hadir',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_hadir' => 'datetime',
        ];
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda', 'id_agenda');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }

    public function qrcode()
    {
        return $this->belongsTo(QRCode::class, 'id_qrcode', 'id_qrcode');
    }

    public static function generateLaporanKehadiran()
    {
        return self::with(['agenda', 'peserta', 'qrcode'])->latest('waktu_hadir')->get();
    }

    public static function generateStatistik(): array
    {
        return [
            'total' => self::count(),
            'hadir' => self::where('status', 'hadir')->count(),
            'izin' => self::where('status', 'izin')->count(),
            'tidak_hadir' => self::where('status', 'tidak_hadir')->count(),
        ];
    }

    public static function mengunduhLaporan(): string
    {
        return route('admin.kehadiran.download');
    }
}
