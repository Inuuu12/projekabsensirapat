<?php

namespace App\Http\Controllers;

use App\Models\QRCode;

class QRCodeController extends Controller
{
    public function generateQR(int $idAgenda)
    {
        return response()->json([
            'success' => true,
            'data' => QRCode::generateQR($idAgenda),
        ]);
    }
}
