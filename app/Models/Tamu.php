<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $table = 'app_md_tamu';
    protected $primaryKey = 'id_tamu';

    protected $fillable = [
        'nik',
        'nama',
        'jabatan',
        'no_hp',
        'asal_instansi',
        'foto_selfie',
        'id_agenda',
    ];
}
