<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
        'alamat_kantor',
        'telepon',
        'email',
        'camat',
        'gps_lat',
        'gps_long',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id_kecamatan', 'id_kecamatan');
    }
}
