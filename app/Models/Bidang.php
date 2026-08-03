<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'app_md_bidang';
    protected $primaryKey = 'id_bidang';

    protected $fillable = [
        'nama_bidang',
    ];
}
