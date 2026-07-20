<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceRecog extends Model
{
    use HasFactory;

    protected $table = 'face_recogs';
    protected $primaryKey = 'id_facerecog';
    protected $fillable = ['id_peserta', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }

    public function aktifkanFR(): bool
    {
        $this->aktif = true;

        return $this->save();
    }

    public static function pindaiWajah(int $idPeserta): bool
    {
        return self::where('id_peserta', $idPeserta)->where('aktif', true)->exists();
    }
}
