<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAduan extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_dataaduan';
    protected $primaryKey = 'id_dataaduan';

    protected $fillable = [
        'nama_pengadu',
        'nomor_pengadu',
        'email',
        'foto',
        'isi_aduan',
        'balasan_admin',
        'status',
        'id_admin',
    ];

    public static function kelolaAduan()
    {
        return self::latest('id_dataaduan')->get();
    }
}
