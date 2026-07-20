<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbook';
    protected $primaryKey = 'id_log';
    protected $fillable = ['id_admin', 'aktivitas', 'waktu'];

    protected function casts(): array
    {
        return ['waktu' => 'datetime'];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public static function lihatLog()
    {
        return self::latest('waktu')->get();
    }

    public static function lihatRiwayat(?int $idAdmin = null)
    {
        return self::when($idAdmin, fn ($query) => $query->where('id_admin', $idAdmin))
            ->latest('waktu')
            ->get();
    }
}
