<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nip', 'nama_pegawai', 'jabatan', 'nomor_hp', 'email'])]
class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'app_md_pegawai';
    protected $primaryKey = 'id_pegawai';
}
