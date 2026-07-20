<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenNotulen extends Model
{
    use HasFactory;

    protected $table = 'dokumen_notulen';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = ['id_agenda', 'namaFile', 'filePath'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda', 'id_agenda');
    }

    public static function uploadDokumen(array $data): self
    {
        return self::create($data);
    }
}
