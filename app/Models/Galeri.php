<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'app_md_galeri';
    protected $primaryKey = 'id_galeri';
    protected $fillable = ['tanggal', 'gambar'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public static function tampilFoto()
    {
        return self::latest()->get();
    }
}
