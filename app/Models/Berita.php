<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'app_md_berita';
    protected $primaryKey = 'id_berita';
    protected $fillable = ['judul', 'isi_berita', 'tanggal', 'gambar', 'sumber'];

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
            ->orWhere('isi_berita', 'like', "%{$keyword}%")
            ->latest('tanggal')
            ->get();
    }
}
