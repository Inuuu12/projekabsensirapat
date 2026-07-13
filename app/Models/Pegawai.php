<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nip', 'nama_Pejabat', 'jabatan'])]
class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai'; // Menggunakan nama tunggal tanpa 's'
    protected $primaryKey = 'id_Pejabat';
}
