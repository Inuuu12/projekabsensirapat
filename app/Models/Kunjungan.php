<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'app_md_kunjungan';
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'nama_pejabat',
        'nama_pengunjung',
        'asal_instansi',
        'nomorhp_pengunjung',
        'email_pengunjung',
        'keperluan',
        'waktu',
        'tanggal_kunjungan',
        'id_admin',
    ];
}
