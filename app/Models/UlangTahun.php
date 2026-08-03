<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlangTahun extends Model
{
    use HasFactory;

    protected $table = 'app_md_ulangtahun';
    protected $primaryKey = 'id_ulangtahun';
    protected $fillable = ['nama', 'tanggal', 'gambar'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public static function tampilkanUlangTahunPegawai()
    {
        return Pegawai::ulangTahunPegawai();
    }
}
