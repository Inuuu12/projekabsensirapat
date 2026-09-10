<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_dinas';
    protected $primaryKey = 'id_dinas';

    protected $fillable = [
        'kode_dinas',
        'nama_dinas',
        'alamat',
        'telepon',
        'email',
        'kepala_dinas',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id_dinas', 'id_dinas');
    }
}
