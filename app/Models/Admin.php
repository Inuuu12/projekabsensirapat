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
    protected $table = 'app_md_admin';

    //primary key
    protected $primaryKey = 'id_admin';
    
    //Kolom yang boleh diisi
    protected $fillable = [
        'username',
        'nama',
        'password',
    ];

    //sembunyikan password
    protected $hidden=[
        'password',
    ];
    
    //hash password otomatis
    protected $casts=[
        'password'=>'hashed',
    ];
}
