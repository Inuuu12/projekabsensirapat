<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::latest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawai'));
    }
    public function create()
    {
        return view('pegawai.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai'    => 'required|string|max:255',
            'nip'             => 'required|string|max:18|regex:/^[0-9]+$/|unique:app_md_pegawai,nip', // nip harus unik
            'tanggal_lahir'   => 'nullable|date',
            'jabatan'         => 'required|string|max:255',
            'bidang'          => 'nullable|string|max:255',
            'nomor_hp'        => 'nullable|string|max:13',
            'email'           => 'nullable|email|max:255',
        ], [
            // Kustomisasi pesan error (opsional)
            'nip.unique' => 'NIP ini sudah terdaftar di sistem.',
        ]);
        $pegawai = Pegawai::create($validatedData);
        return redirect()->route('pegawai.index')->with('success','data pegawai berhasil ditambahkan');
    }
    public function edit(pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }
    public function update(Request $request, pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nama_pegawai'    => 'required|string|max:255',
            'nip'     => 'required|string|max:18|regex:/^[0-9]+$/|unique:app_md_pegawai,nip,' . $pegawai->id_pegawai . ',id_pegawai',// nip harus unik, kecuali untu
            'tanggal_lahir'   => 'nullable|date',
            'jabatan' => 'required|string|max:255',
            'bidang'  => 'required|string|max:255',
            'nomor_hp'   => 'required|string|max:13',
            'email'   => 'required|email|max:255',
        ]);
        $pegawai->update($validatedData);
        return redirect()->route('pegawai.index')->with('success','data pegawai berhasil diubah');
    }
    public function destroy(pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success','data pegawai berhasil dihapus');
    }
}
