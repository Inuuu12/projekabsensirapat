<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function lihatLog()
    {
        return response()->json(['success' => true, 'data' => Logbook::lihatLog()]);
    }

    public function lihatRiwayat(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => Logbook::lihatRiwayat($request->integer('id_admin') ?: null),
        ]);
    }
}
