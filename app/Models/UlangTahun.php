<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlangTahun extends Model
{
    use HasFactory;

    protected $table = 'ulang_tahun';
    protected $primaryKey = 'id_ulangtahun';
    protected $fillable = ['nama', 'tanggal'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public static function tampilkanUlangTahunPegawai()
    {
        return self::orderByRaw('MONTH(tanggal), DAY(tanggal)')->get();
    }
}
