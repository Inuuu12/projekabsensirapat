<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    // Menghubungkan ke tabel fisik 'aduan' di database
    protected $table = 'aduan';

    // Primary key custom sesuai rancangan diagram kamu
    protected $primaryKey = 'id_Aduan';

    protected $fillable = [
        'Nama_Pengadu',
        'isi_Aduan',
        'status'
    ];

    public $timestamps = true;
}
