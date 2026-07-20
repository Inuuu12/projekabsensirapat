<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuaca extends Model
{
    use HasFactory;

    protected $table = 'cuaca';
    protected $primaryKey = 'id_cuaca';
    protected $fillable = ['lokasi', 'suhu', 'kondisi', 'kelembapan'];

    public static function ambilCuaca()
    {
        return self::latest()->get();
    }

    public static function cariCuaca(string $lokasi)
    {
        return self::where('lokasi', 'like', "%{$lokasi}%")->latest()->get();
    }
}
