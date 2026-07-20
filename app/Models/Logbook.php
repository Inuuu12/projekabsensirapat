<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'app_md_logbook';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_agenda',
        'catatan',
        'waktu_isi',
    ];
}
