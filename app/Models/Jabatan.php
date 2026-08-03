<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'app_md_jabatan';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'kategori',
    ];
}
