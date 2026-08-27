<?php

namespace App\Models;

class DataMasukan extends DataAduan
{
    // Alias model for backwards-compatibility
    public static function kelolaMasukan()
    {
        return self::kelolaAduan();
    }
}
