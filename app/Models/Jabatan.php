<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'sirapi_md_jabatan';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'kategori',
    ];
}
