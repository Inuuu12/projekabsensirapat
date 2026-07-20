<?php

namespace App\Models;

class DataMasukan extends Masukan
{
    protected $appends = ['isi'];

    public function getIsiAttribute(): string
    {
        return $this->isi_masukan;
    }

    public static function kelolaMasukan()
    {
        return self::with('statusMasukan')->latest()->get();
    }
}
