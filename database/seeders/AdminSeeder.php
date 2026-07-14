<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin_utama'],
            [
                'email'    => 'admin_utama@bogor.kab.id',
                'nama'     => 'Administrator Sistem',
                'password' => Hash::make('R4has!A123'), // Ini password Anda
            ]
        );
    }
}
