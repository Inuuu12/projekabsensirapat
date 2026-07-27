<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenNotulen extends Model
{
    use HasFactory;

    protected $table = 'app_md_dokumen_notulen';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = ['id_agenda', 'jenis_dokumen', 'nama_file', 'file_path'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda', 'id_agenda');
    }

    public static function uploadDokumen(array $data): self
    {
        return self::updateOrCreate(
            [
                'id_agenda' => $data['id_agenda'],
                'jenis_dokumen' => $data['jenis_dokumen'],
            ],
            [
                'nama_file' => $data['nama_file'],
                'file_path' => $data['file_path'],
            ],
        );
    }
}
