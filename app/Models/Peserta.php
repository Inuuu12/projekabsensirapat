<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama', 'jabatan', 'instansi', 'jenis_peserta', 'nomor_hp', 'email'])]
class Peserta extends Model
{
    use HasFactory;
    protected $table = 'app_md_peserta';
    protected $primaryKey = 'id_peserta';
}
