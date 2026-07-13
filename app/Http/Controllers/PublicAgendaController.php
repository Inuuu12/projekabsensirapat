<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class PublicAgendaController extends Controller
{
    // fungsi publik buat nyari agenda rapat berdasarkan kata kunci
    public function cari_Agenda(Request $request)
    {
        // ambil keyword pencarian dari parameter query (?keyword=...)
        $keyword = $request->query('keyword');

        // kalau ada keyword, filter berdasarkan nama_agenda
        $agenda = Agenda::when($keyword, function ($query, $keyword) {
            return $query->where('nama_agenda', 'like', "%{$keyword}%");
        })->get();

        return response()->json([
            'success' => true,
            'data'    => $agenda
        ]);
    }
}
