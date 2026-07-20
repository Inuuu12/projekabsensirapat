<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $fillable = ['judul', 'isiBerita', 'tanggal', 'gambar', 'sumber'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public static function ambilBerita()
    {
        return self::latest('tanggal')->get();
    }

    public static function cariBerita(string $keyword)
    {
        return self::where('judul', 'like', "%{$keyword}%")
            ->orWhere('isiBerita', 'like', "%{$keyword}%")
            ->latest('tanggal')
            ->get();
    }
}
