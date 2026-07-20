<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMasukan extends Model
{
    use HasFactory;

    protected $table = 'app_md_datamasukan';
    protected $primaryKey = 'id_datamasukan';

    protected $fillable = [
        'nama_pengadu',
        'nomor_pengadu',
        'email',
        'foto',
        'isi_aduan',
        'status',
        'id_admin',
    ];

    public static function kelolaMasukan()
    {
        return self::latest('id_datamasukan')->get();
    }
}
