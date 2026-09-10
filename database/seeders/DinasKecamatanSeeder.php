<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DinasKecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Seed Master Data Dinas
        $dinasData = [
            [
                'kode_dinas' => 'DISKOMINFO',
                'nama_dinas' => 'Dinas Komunikasi dan Informatika',
                'alamat' => 'Jl. Tegar Beriman, Cibinong, Kab. Bogor',
                'telepon' => '(021) 8750001',
                'email' => 'diskominfo@bogorkab.go.id',
                'kepala_dinas' => 'Bambang Widodo, S.STP, M.Si',
            ],
            [
                'kode_dinas' => 'DISDIK',
                'nama_dinas' => 'Dinas Pendidikan',
                'alamat' => 'Jl. Nyaman No. 1, Cibinong, Kab. Bogor',
                'telepon' => '(021) 8753123',
                'email' => 'disdik@bogorkab.go.id',
                'kepala_dinas' => 'Bambang Supriyadi, M.Pd',
            ],
            [
                'kode_dinas' => 'DINKES',
                'nama_dinas' => 'Dinas Kesehatan',
                'alamat' => 'Jl. Bersih No. 2, Cibinong, Kab. Bogor',
                'telepon' => '(021) 8752456',
                'email' => 'dinkes@bogorkab.go.id',
                'kepala_dinas' => 'dr. Tri Wahyu, M.Kes',
            ],
            [
                'kode_dinas' => 'DISHUB',
                'nama_dinas' => 'Dinas Perhubungan',
                'alamat' => 'Jl. Raya Sukabumi Km 2, Ciawi, Kab. Bogor',
                'telepon' => '(0251) 8241001',
                'email' => 'dishub@bogorkab.go.id',
                'kepala_dinas' => 'Agus Ridho, S.H, M.H',
            ],
            [
                'kode_dinas' => 'PUPR',
                'nama_dinas' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'alamat' => 'Jl. Tegar Beriman, Pakansari, Cibinong',
                'telepon' => '(021) 8754890',
                'email' => 'pupr@bogorkab.go.id',
                'kepala_dinas' => 'Iwan Setiawan, S.T, M.T',
            ],
            [
                'kode_dinas' => 'BAPPEDALITBANG',
                'nama_dinas' => 'Badan Perencanaan Pembangunan Penelitian dan Pengembangan Daerah',
                'alamat' => 'Jl. Tegar Beriman, Cibinong, Kab. Bogor',
                'telepon' => '(021) 8752002',
                'email' => 'bappedalitbang@bogorkab.go.id',
                'kepala_dinas' => 'Ajat Rochmat Jatnika, S.T, M.Si',
            ],
            [
                'kode_dinas' => 'BAPPENDA',
                'nama_dinas' => 'Badan Pengelolaan Pendapatan Daerah',
                'alamat' => 'Jl. Tegar Beriman No. 1, Cibinong',
                'telepon' => '(021) 8753000',
                'email' => 'bappenda@bogorkab.go.id',
                'kepala_dinas' => 'Aris Nurjatmiko, S.STP',
            ],
            [
                'kode_dinas' => 'SATPOLPP',
                'nama_dinas' => 'Satuan Polisi Pamong Praja',
                'alamat' => 'Jl. Tegar Beriman, Cibinong, Kab. Bogor',
                'telepon' => '(021) 8751111',
                'email' => 'satpolpp@bogorkab.go.id',
                'kepala_dinas' => 'Cecep Imam Nagararasit, M.Si',
            ],
        ];

        foreach ($dinasData as $dinas) {
            DB::table('sirapi_md_dinas')->updateOrInsert(
                ['kode_dinas' => $dinas['kode_dinas']],
                $dinas + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // 2. Seed Master Data 40 Kecamatan di Kabupaten Bogor
        $kecamatanList = [
            ['nama' => 'Cibinong', 'alamat' => 'Jl. Kayu Manis No.30 Kelurahan Cirimekar, Kecamatan Cibinong', 'telp' => '(021) 8753879', 'email' => 'kecibinong@bogorkab.go.id', 'lat' => '-6.473271', 'long' => '106.853688'],
            ['nama' => 'Gunung Putri', 'alamat' => 'Jl. Barokah, Wanaherang, Gunung Putri, Bogor 16965', 'telp' => '(021) 8672122', 'email' => 'kecgunungputri@bogorkab.go.id', 'lat' => '-6.423838', 'long' => '106.940441'],
            ['nama' => 'Citeureup', 'alamat' => 'Jln. Mayor Oking Jayaatmaja No 107 Citeureup, Bogor 16810', 'telp' => '(021) 8752312', 'email' => 'kecciteureup@bogorkab.go.id', 'lat' => '-6.486906', 'long' => '106.878721'],
            ['nama' => 'Sukaraja', 'alamat' => 'JL Dharmais, Cimandala, Sukaraja, Bogor 16710', 'telp' => '(0251) 8652476', 'email' => 'kecsukaraja@bogorkab.go.id', 'lat' => '-6.538937', 'long' => '106.822428'],
            ['nama' => 'Babakan Madang', 'alamat' => 'Jl. Raya Babakan Madang No. 4', 'telp' => '021-87951920', 'email' => 'kecbabakanmadang@bogorkab.go.id', 'lat' => '-6.570999', 'long' => '106.865713'],
            ['nama' => 'Jonggol', 'alamat' => 'Jl. Raya Alun-Alun Utara No.7, Jonggol, Bogor 16830', 'telp' => '(021) 89931171', 'email' => 'kecjonggol@bogorkab.go.id', 'lat' => '-6.467843', 'long' => '107.066056'],
            ['nama' => 'Cileungsi', 'alamat' => 'Komplek Perumahan Metland Transyogi Jl. Gandaria Utara No. 1', 'telp' => '(021) 8230085', 'email' => 'keccileungsi@bogorkab.go.id', 'lat' => '-6.394571', 'long' => '106.977392'],
            ['nama' => 'Cariu', 'alamat' => 'Jl. Brigjen Dharsono No.01 Cariu Kabupaten Bogor 16840', 'telp' => '(021) 89960904', 'email' => 'keccariu@bogorkab.go.id', 'lat' => '-6.503854', 'long' => '107.133084'],
            ['nama' => 'Sukamakmur', 'alamat' => 'Jln. Raya Sukamakmur No. 1 Kec. Sukamakmur Kabupaten Bogor 16830', 'telp' => '-', 'email' => 'kecsukamakmur@bogorkab.go.id', 'lat' => '-6.565829', 'long' => '106.994981'],
            ['nama' => 'Parung', 'alamat' => 'Jl. Raden Demang Arya, Desa Waru Jaya, Kecamatan Parung', 'telp' => '0251-8611088', 'email' => 'kecparung@bogorkab.go.id', 'lat' => '-6.420047', 'long' => '106.732847'],
            ['nama' => 'Gunung Sindur', 'alamat' => 'Jl.Atma Asmawi NO. 58 Gunungsindur', 'telp' => '021-7562152', 'email' => 'kecamatangunungsindur@bogorkab.go.id', 'lat' => '-6.385779', 'long' => '106.675057'],
            ['nama' => 'Kemang', 'alamat' => 'Jl. Raya Kemang Kiara No. 57 - 16310', 'telp' => '(0251) 7535154', 'email' => 'keckemang@bogorkab.go.id', 'lat' => '-6.513809', 'long' => '106.754521'],
            ['nama' => 'Bojong Gede', 'alamat' => 'Jl. Raya Bojonggede No.316, Bojonggede 16320', 'telp' => '(021) 8781078', 'email' => 'kecbojonggede@bogorkab.go.id', 'lat' => '-6.483816', 'long' => '106.799348'],
            ['nama' => 'Leuwiliang', 'alamat' => 'Jl. Moh Noh Nur, Leuwiliang, Bogor 16640', 'telp' => '-', 'email' => 'kecleuwiliang@bogorkab.go.id', 'lat' => '-6.57677', 'long' => '106.635715'],
            ['nama' => 'Ciampea', 'alamat' => 'Bojong Rangkas, Ciampea, Bogor 16620', 'telp' => '-', 'email' => 'kecciampea@bogorkab.go.id', 'lat' => '-6.554946', 'long' => '106.697082'],
            ['nama' => 'Cibungbulang', 'alamat' => 'Jalan KH Umar Cirangkong, Desa Cemplang Kec.Cibungbulang', 'telp' => '-', 'email' => 'keccibungbulang@bogorkab.go.id', 'lat' => '-6.57449', 'long' => '106.6669'],
            ['nama' => 'Pamijahan', 'alamat' => 'Jl.Gunung Salak Endah no.2 Desa Gunung Sari', 'telp' => '(0251) 8640509', 'email' => 'kecpamijahan@bogorkab.go.id', 'lat' => '-6.671667', 'long' => '106.663717'],
            ['nama' => 'Rumpin', 'alamat' => 'Jl. Prada Samlawi No.02, Rumpin, Bogor 16350', 'telp' => '-', 'email' => 'kecrumpin@bogorkab.go.id', 'lat' => '-6.442162', 'long' => '106.640901'],
            ['nama' => 'Jasinga', 'alamat' => 'Jalan Raya Bogor - Cigelung No.01 Bogor 16670', 'telp' => '(0251) 8688785', 'email' => 'kecjasinga@bogorkab.go.id', 'lat' => '-6.48351', 'long' => '106.469633'],
            ['nama' => 'Parung Panjang', 'alamat' => 'Jl. Raya Moh Toha Nomor 1 Parungpanjang', 'telp' => '(021) 5979148', 'email' => 'kecparungpanjang@bogorkab.go.id', 'lat' => '-6.341668', 'long' => '106.571467'],
            ['nama' => 'Nanggung', 'alamat' => 'Jl. Raya Ace Tabrani No.32, Parakan Muncang', 'telp' => '-', 'email' => 'kecnanggung@bogorkab.go.id', 'lat' => '-6.597729', 'long' => '106.539593'],
            ['nama' => 'Cigudeg', 'alamat' => 'JL. Raya Jasinga Km. 35, Kode Pos 16660', 'telp' => '0251 8682011', 'email' => 'keccigudeg@bogorkab.go.id', 'lat' => '-6.547643', 'long' => '106.532664'],
            ['nama' => 'Tenjo', 'alamat' => 'Jln.Raya Jasinga-Tenjo KM.18.55 Bogor 16370', 'telp' => '021 59760015', 'email' => 'kectenjo@bogorkab.go.id', 'lat' => '-6.339321', 'long' => '106.440804'],
            ['nama' => 'Ciawi', 'alamat' => 'Jl. Raya K.H.R Moch. Toha No. 362 Ciawi-Bogor 16720', 'telp' => '(0251) 8240234', 'email' => 'kecciawi@bogorkab.go.id', 'lat' => '-6.662181', 'long' => '106.853163'],
            ['nama' => 'Cisarua', 'alamat' => 'Jl. Raya Puncak - Cianjur No.520, Leuwimalang', 'telp' => '0251 8254031', 'email' => 'keccisarua@bogorkab.go.id', 'lat' => '-6.680613', 'long' => '106.934203'],
            ['nama' => 'Megamendung', 'alamat' => 'Jl. Lentan Suryanta No. 9 Sukamaju 16770', 'telp' => '0251-7555536', 'email' => 'kecmegamendung@bogorkab.go.id', 'lat' => '-6.674893', 'long' => '106.883359'],
            ['nama' => 'Caringin', 'alamat' => 'Jl. Mayjen HR. Edi Sukma KM. 17 Caringin', 'telp' => '0251 8241392', 'email' => 'keccaringin@bogorkab.go.id', 'lat' => '-6.703843', 'long' => '106.824883'],
            ['nama' => 'Cijeruk', 'alamat' => 'Jalan KH. Halimi No. 04 Desa Cipelang', 'telp' => '(0251) 8212375', 'email' => 'keccijeruk@bogorkab.go.id', 'lat' => '-6.697987', 'long' => '106.796579'],
            ['nama' => 'Ciomas', 'alamat' => 'Padusuka No.343, Pagelaran, Ciomas, Bogor 16610', 'telp' => '-', 'email' => 'kecciomas@bogorkab.go.id', 'lat' => '-6.602435', 'long' => '106.76531'],
            ['nama' => 'Dramaga', 'alamat' => 'Jl.R.Soewandana No.74 Desa Dramaga', 'telp' => '0251-8623002', 'email' => 'kecdramaga@bogorkab.go.id', 'lat' => '-6.575719', 'long' => '106.737937'],
            ['nama' => 'Tamansari', 'alamat' => 'Sirnagalih, Tamansari, Bogor 16610', 'telp' => '(0251) 8487111', 'email' => 'kectamansari@bogorkab.go.id', 'lat' => '-6.644802', 'long' => '106.765653'],
            ['nama' => 'Klapanunggal', 'alamat' => 'Jl. Raya Narogong, Kembang Kuning, Klapa Nunggal', 'telp' => '-', 'email' => 'kecklapanunggal@bogorkab.go.id', 'lat' => '-6.449903', 'long' => '106.935872'],
            ['nama' => 'Ciseeng', 'alamat' => 'Jl. Raya Ciseeng, Kabupaten Bogor', 'telp' => '-', 'email' => 'kecciseeng@bogorkab.go.id', 'lat' => '-6.446257', 'long' => '106.685053'],
            ['nama' => 'Rancabungur', 'alamat' => 'Jl. Letkol Atang Senjaya, Rancabungur', 'telp' => '(0251) 8624001', 'email' => 'kecrancabungur@bogorkab.go.id', 'lat' => '-6.540684', 'long' => '106.709472'],
            ['nama' => 'Sukajaya', 'alamat' => 'Jl. Raya Sukajaya Km. 08', 'telp' => '0251 8682917', 'email' => 'kecsukajaya@bogorkab.go.id', 'lat' => '-6.594062', 'long' => '106.477977'],
            ['nama' => 'Tanjungsari', 'alamat' => 'Pasir Tanjung, Tanjungsari, Bogor 16840', 'telp' => '-', 'email' => 'kectanjungsari@bogorkab.go.id', 'lat' => '-6.605575', 'long' => '107.149038'],
            ['nama' => 'Tajurhalang', 'alamat' => 'Jl. Manunggal No. 1 Tajurhalang', 'telp' => '(0251) 8552610', 'email' => 'kectajurhalang@bogorkab.go.id', 'lat' => '-6.4745', 'long' => '106.757258'],
            ['nama' => 'Cigombong', 'alamat' => 'Cigombong, Bogor 16110', 'telp' => '-', 'email' => 'keccigombong@bogorkab.go.id', 'lat' => '-6.743253', 'long' => '106.803152'],
            ['nama' => 'Leuwisadeng', 'alamat' => 'Jalan Raya Bogor - Jasinga Km. 24', 'telp' => '(0251) 8643608', 'email' => 'kecleuwisadeng@bogorkab.go.id', 'lat' => '-6.565256', 'long' => '106.614498'],
            ['nama' => 'Tenjolaya', 'alamat' => 'Jl. Raya Abdul Fatah, Tapos I, Tenjolaya', 'telp' => '-', 'email' => 'kectenjolaya@bogorkab.go.id', 'lat' => '-6.644707', 'long' => '106.693678'],
        ];

        foreach ($kecamatanList as $kec) {
            $slug = Str::slug($kec['nama']);
            $kode = 'KEC-' . strtoupper(str_replace('-', '', $slug));
            DB::table('sirapi_md_kecamatan')->updateOrInsert(
                ['nama_kecamatan' => 'Kecamatan ' . $kec['nama']],
                [
                    'kode_kecamatan' => $kode,
                    'alamat_kantor' => $kec['alamat'],
                    'telepon' => $kec['telp'],
                    'email' => $kec['email'],
                    'camat' => 'Camat ' . $kec['nama'],
                    'gps_lat' => $kec['lat'],
                    'gps_long' => $kec['long'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 3. Seed Sampel Akun Dinas & Akun Kecamatan ke sirapi_md_admin
        $diskominfo = DB::table('sirapi_md_dinas')->where('kode_dinas', 'DISKOMINFO')->first();
        if ($diskominfo) {
            DB::table('sirapi_md_admin')->updateOrInsert(
                ['username' => 'dinas_diskominfo'],
                [
                    'nama' => 'Admin Diskominfo',
                    'password' => Hash::make('dinas123'),
                    'role' => 'dinas',
                    'id_dinas' => $diskominfo->id_dinas,
                    'email' => 'diskominfo@bogorkab.go.id',
                    'nomor_hp' => '081234567890',
                    'status' => 'aktif',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $kecCibinong = DB::table('sirapi_md_kecamatan')->where('nama_kecamatan', 'Kecamatan Cibinong')->first();
        if ($kecCibinong) {
            DB::table('sirapi_md_admin')->updateOrInsert(
                ['username' => 'camat_cibinong'],
                [
                    'nama' => 'Admin Kecamatan Cibinong',
                    'password' => Hash::make('camat123'),
                    'role' => 'kecamatan',
                    'id_kecamatan' => $kecCibinong->id_kecamatan,
                    'email' => 'kecibinong@bogorkab.go.id',
                    'nomor_hp' => '081298765432',
                    'status' => 'aktif',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
