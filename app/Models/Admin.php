<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    //table
    protected $table = 'sirapi_md_admin';

    //primary key
    protected $primaryKey = 'id_admin';
    
    //Kolom yang boleh diisi
    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
        'id_dinas',
        'id_kecamatan',
        'email',
        'nomor_hp',
        'status',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'superadmin']);
    }

    public function isAdminDinas(): bool
    {
        return in_array($this->role, ['admin_dinas', 'dinas']);
    }

    public function isAdminKecamatan(): bool
    {
        return in_array($this->role, ['admin_kecamatan', 'kecamatan']);
    }

    /**
     * Dapatkan info lengkap profil instansi admin yang sedang login
     */
    public function getInstansiInfo(): array
    {
        if ($this->isAdminDinas() && $this->id_dinas && $this->dinas) {
            $nama = $this->dinas->nama_dinas;
            $kode = $this->dinas->kode_dinas ?: $nama;
            $alamat = $this->dinas->alamat ?: 'Cibinong, Kabupaten Bogor';
            return [
                'tipe' => 'dinas',
                'nama' => $nama,
                'singkatan' => $kode,
                'alamat' => $alamat,
                'id_dinas' => $this->id_dinas,
                'id_kecamatan' => null,
            ];
        }

        if ($this->isAdminKecamatan() && $this->id_kecamatan && $this->kecamatan) {
            $nama = $this->kecamatan->nama_kecamatan;
            $kode = $this->kecamatan->kode_kecamatan ?: $nama;
            $alamat = $this->kecamatan->alamat_kantor ?: 'Kabupaten Bogor';
            return [
                'tipe' => 'kecamatan',
                'nama' => $nama,
                'singkatan' => $kode,
                'alamat' => $alamat,
                'id_dinas' => null,
                'id_kecamatan' => $this->id_kecamatan,
            ];
        }

        // Default: Superadmin / Diskominfo Pusat
        return [
            'tipe' => 'superadmin',
            'nama' => 'Dinas Komunikasi & Informatika (Diskominfo)',
            'singkatan' => 'Diskominfo',
            'alamat' => 'Jl. Tegar Beriman, Cibinong, Kabupaten Bogor (Pusat Pemkab Bogor)',
            'id_dinas' => 1,
            'id_kecamatan' => null,
        ];
    }

    //sembunyikan password
    protected $hidden=[
        'password',
    ];
    
    //hash password otomatis
    protected $casts=[
        'password'=>'hashed',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }
}

