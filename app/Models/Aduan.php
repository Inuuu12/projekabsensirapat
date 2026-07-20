<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    protected $table = 'app_md_datamasukan';

    protected $primaryKey = 'id_datamasukan';

    protected $fillable = [
        'nama_pengadu',
        'nomor_pengadu',
        'email',
        'foto',
        'isi_aduan',
        'status',
        'id_admin'
    ];

    public $timestamps = true;
}
