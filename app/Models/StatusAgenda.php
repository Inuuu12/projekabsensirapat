<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAgenda extends Model
{
    use HasFactory;

    protected $table = 'status_agenda';
    protected $primaryKey = 'id_statusAgenda';
    protected $fillable = ['nama_status'];

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'id_statusAgenda', 'id_statusAgenda');
    }
}
