<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMasukan extends Model
{
    use HasFactory;

    protected $table = 'status_masukan';
    protected $primaryKey = 'id_statusMasukan';
    protected $fillable = ['nama_status'];

    public function masukan()
    {
        return $this->hasMany(Masukan::class, 'id_statusMasukan', 'id_statusMasukan');
    }
}
