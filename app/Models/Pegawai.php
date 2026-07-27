<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'app_md_pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'foto',
        'nama_pegawai',    
        'nip',
        'jabatan',
        'bidang',
        'nomor_hp',
        'email',
    ];
}
