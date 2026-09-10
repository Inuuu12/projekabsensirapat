<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminDinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dinas Komunikasi & Informatika
        $kominfo = \App\Models\Dinas::firstOrCreate(['nama_dinas' => 'Dinas Komunikasi & Informatika']);
        \App\Models\Admin::updateOrCreate(
            ['username' => 'adminkominfo'],
            [
                'nama' => 'Admin Kominfo',
                'password' => \Illuminate\Support\Facades\Hash::make('kominfo123'),
                'role' => 'admin_dinas',
                'id_dinas' => $kominfo->id_dinas
            ]
        );

        // 2. Dinas Pendidikan
        $pendidikan = \App\Models\Dinas::firstOrCreate(['nama_dinas' => 'Dinas Pendidikan']);
        \App\Models\Admin::updateOrCreate(
            ['username' => 'adminpendidikan'],
            [
                'nama' => 'Admin Pendidikan',
                'password' => \Illuminate\Support\Facades\Hash::make('pendidikan123'),
                'role' => 'admin_dinas',
                'id_dinas' => $pendidikan->id_dinas
            ]
        );

        // 3. Dinas Kesehatan
        $kesehatan = \App\Models\Dinas::firstOrCreate(['nama_dinas' => 'Dinas Kesehatan']);
        \App\Models\Admin::updateOrCreate(
            ['username' => 'adminkesehatan'],
            [
                'nama' => 'Admin Kesehatan',
                'password' => \Illuminate\Support\Facades\Hash::make('kesehatan123'),
                'role' => 'admin_dinas',
                'id_dinas' => $kesehatan->id_dinas
            ]
        );
    }
}
