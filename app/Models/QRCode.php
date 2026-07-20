<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;

    protected $table = 'qrcodes';
    protected $primaryKey = 'id_qrcode';
    protected $fillable = ['id_agenda', 'qr_code_path'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'id_agenda', 'id_agenda');
    }

    public static function generateQR(int $idAgenda): self
    {
        return self::updateOrCreate(
            ['id_agenda' => $idAgenda],
            ['qr_code_path' => "qrcodes/agenda-{$idAgenda}.png"]
        );
    }
}
