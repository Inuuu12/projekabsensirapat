<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'app_md_agenda';
    protected $primaryKey = 'id_agenda';

    protected $fillable = [
        'nama_agenda',
        'tanggal',
        'waktu',
        'kuota',
        'lokasi',
        'status_fr',
        'status_qr',
        'id_ruangrapat',
        'id_statusagenda',
    ];
}
