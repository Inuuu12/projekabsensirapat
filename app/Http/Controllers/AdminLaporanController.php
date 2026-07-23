<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class AdminLaporanController extends Controller
{
    public function laporan()
    {
        $admin = Auth::guard('admin')->user();
        $totalLogbook = Logbook::count();

        return view('admin.laporan.index', compact('admin', 'totalLogbook'));
    }

    public function cetak_Laporan()
    {
        $logbook = Logbook::all();

        return response()->json(['message' => 'Laporan logbook berhasil ditarik', 'data' => $logbook]);
    }
}
