<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    protected $fillable = ['id_admin', 'nama', 'instansi', 'nomor_hp', 'foto_selfie', 'tanggal_kunjungan'];

    protected function casts(): array
    {
        return ['tanggal_kunjungan' => 'date'];
    }

    public static function kelolaKunjungan(array $data): self
    {
        return self::create($data);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
