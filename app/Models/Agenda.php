<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'app_md_agenda';
    protected $primaryKey = 'id_agenda';

    protected $fillable = [
        'nama_agenda',
        'kategori_surat',
        'asal_surat',
        'ditugaskan',
        'lampiran',
        'tanggal',
        'waktu',
        'waktu_selesai',
        'kuota',
        'lokasi',
        'status_fr',
        'status_qr',
        'id_ruangrapat',
        'id_statusagenda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'status_fr' => 'boolean',
        ];
    }

    public function statusAgenda()
    {
        return $this->belongsTo(StatusAgenda::class, 'id_statusagenda', 'id_statusagenda');
    }
}
