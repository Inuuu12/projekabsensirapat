<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAgenda extends Model
{
    use HasFactory;

    protected $table = 'app_md_statusagenda';
    protected $primaryKey = 'id_statusagenda';
    protected $fillable = ['nama_status'];

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'id_statusagenda', 'id_statusagenda');
    }
}
