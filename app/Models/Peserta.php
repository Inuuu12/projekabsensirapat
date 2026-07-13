<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama', 'jenis_peserta'])]
class Peserta extends Model
{
    use HasFactory;
    protected $table = 'peserta'; // Menggunakan nama tunggal tanpa 's'
    protected $primaryKey = 'id_Peserta';
}
