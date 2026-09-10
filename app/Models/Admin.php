<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    //table
    protected $table = 'sirapi_md_admin';

    //primary key
    protected $primaryKey = 'id_admin';
    
    //Kolom yang boleh diisi
    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
        'id_dinas',
        'id_kecamatan',
        'email',
        'nomor_hp',
        'status',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdminDinas()
    {
        return $this->role === 'admin_dinas';
    }

    //sembunyikan password
    protected $hidden=[
        'password',
    ];
    
    //hash password otomatis
    protected $casts=[
        'password'=>'hashed',
    ];



    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }
}

