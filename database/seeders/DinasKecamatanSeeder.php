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

        // 1. Bersihkan dummy row jika ada (contoh: id_dinas 9 dengan kode kosong)
        DB::table('sirapi_md_dinas')
            ->where('id_dinas', 9)
            ->where(function ($q) {
                $q->whereNull('kode_dinas')->orWhere('kode_dinas', '');
            })
            ->delete();

        // Kamus Data Resmi OPD / Dinas / Badan / RSUD Kabupaten Bogor
        $agencyMeta = [
            'BAKESBANGPOL' => [
                'kode' => 'BAKESBANGPOL',
                'nama' => 'Badan Kesatuan Bangsa dan Politik',
                'telepon' => '(021) 87901234',
                'email' => 'bakesbangpol@bogorkab.go.id'
            ],
            'BAPPENDA' => [
                'kode' => 'BAPPENDA',
                'nama' => 'Badan Pengelolaan Pendapatan Daerah',
                'telepon' => '(021) 87912462',
                'email' => 'bappenda@bogorkab.go.id'
            ],
            'BAPPERIDA' => [
                'kode' => 'BAPPERIDA',
                'nama' => 'Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah',
                'telepon' => '(021) 8758605',
                'email' => 'bapperida@bogorkab.go.id'
            ],
            'BKPSDM' => [
                'kode' => 'BKPSDM',
                'nama' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
                'telepon' => '(021) 8758071',
                'email' => 'bkpsdm@bogorkab.go.id'
            ],
            'BPBD' => [
                'kode' => 'BPBD',
                'nama' => 'Badan Penanggulangan Bencana Daerah',
                'telepon' => '(021) 87914800',
                'email' => 'bpbd@bogorkab.go.id'
            ],
            'BPKAD' => [
                'kode' => 'BPKAD',
                'nama' => 'Badan Pengelolaan Keuangan dan Aset Daerah',
                'telepon' => '(021) 8758607',
                'email' => 'bpkad@bogorkab.go.id'
            ],
            'DAMKAR' => [
                'kode' => 'DAMKAR',
                'nama' => 'Dinas Pemadam Kebakaran',
                'telepon' => '(021) 8753540',
                'email' => 'damkar@bogorkab.go.id'
            ],
            'DAPD' => [
                'kode' => 'DAPD',
                'nama' => 'Dinas Arsip dan Perpustakaan Daerah',
                'telepon' => '(021) 8759367',
                'email' => 'dapd@bogorkab.go.id'
            ],
            'DINKES' => [
                'kode' => 'DINKES',
                'nama' => 'Dinas Kesehatan',
                'telepon' => '(021) 8751070',
                'email' => 'dinkes@bogorkab.go.id'
            ],
            'DINSOS' => [
                'kode' => 'DINSOS',
                'nama' => 'Dinas Sosial',
                'telepon' => '(021) 8751410',
                'email' => 'dinsos@bogorkab.go.id'
            ],
            'DISBUD' => [
                'kode' => 'DISBUD',
                'nama' => 'Dinas Kebudayaan dan Kepariwisataan',
                'telepon' => '(0251) 8651234',
                'email' => 'disbud@bogorkab.go.id'
            ],
            'DISDAGIN' => [
                'kode' => 'DISDAGIN',
                'nama' => 'Dinas Perdagangan dan Perindustrian',
                'telepon' => '(021) 8758608',
                'email' => 'disdagin@bogorkab.go.id'
            ],
            'DISDIK' => [
                'kode' => 'DISDIK',
                'nama' => 'Dinas Pendidikan',
                'telepon' => '(021) 8753191',
                'email' => 'disdik@bogorkab.go.id'
            ],
            'DISDUKCAKPIL' => [
                'kode' => 'DISDUKCAPIL',
                'nama' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'telepon' => '(021) 8758606',
                'email' => 'disdukcapil@bogorkab.go.id'
            ],
            'DISHUB' => [
                'kode' => 'DISHUB',
                'nama' => 'Dinas Perhubungan',
                'telepon' => '(0251) 8653291',
                'email' => 'dishub@bogorkab.go.id'
            ],
            'DISKANAK' => [
                'kode' => 'DISKANAK',
                'nama' => 'Dinas Perikanan dan Peternakan',
                'telepon' => '(021) 8758609',
                'email' => 'diskanak@bogorkab.go.id'
            ],
            'DISKOMINFO' => [
                'kode' => 'DISKOMINFO',
                'nama' => 'Dinas Komunikasi dan Informatika',
                'telepon' => '(021) 8758605',
                'email' => 'diskominfo@bogorkab.go.id'
            ],
            'DISKOPUKM' => [
                'kode' => 'DISKOPUKM',
                'nama' => 'Dinas Koperasi, Usaha Kecil dan Menengah',
                'telepon' => '(021) 87901111',
                'email' => 'diskopukm@bogorkab.go.id'
            ],
            'DISNAKER' => [
                'kode' => 'DISNAKER',
                'nama' => 'Dinas Tenaga Kerja',
                'telepon' => '(021) 8758604',
                'email' => 'disnaker@bogorkab.go.id'
            ],
            'DISPAREKRAF' => [
                'kode' => 'DISPAREKRAF',
                'nama' => 'Dinas Pariwisata dan Kebudayaan',
                'telepon' => '(021) 8758610',
                'email' => 'disparbud@bogorkab.go.id'
            ],
            'DISPORA' => [
                'kode' => 'DISPORA',
                'nama' => 'Dinas Pemuda dan Olahraga',
                'telepon' => '(021) 87918800',
                'email' => 'dispora@bogorkab.go.id'
            ],
            'DISTANHORBUN' => [
                'kode' => 'DISTANHORBUN',
                'nama' => 'Dinas Tanaman Pangan, Hortikultura dan Perkebunan',
                'telepon' => '(021) 8758611',
                'email' => 'distanhorbun@bogorkab.go.id'
            ],
            'DKP' => [
                'kode' => 'DKP',
                'nama' => 'Dinas Ketahanan Pangan',
                'telepon' => '(021) 8758612',
                'email' => 'dkp@bogorkab.go.id',
                'alamat' => 'Komplek Perkantoran Pemda, Jl. Bersih, Kelurahan Tengah, Cibinong'
            ],
            'DLH' => [
                'kode' => 'DLH',
                'nama' => 'Dinas Lingkungan Hidup',
                'telepon' => '(021) 8758613',
                'email' => 'dlh@bogorkab.go.id'
            ],
            'DP3AP2KB' => [
                'kode' => 'DP3AP2KB',
                'nama' => 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana',
                'telepon' => '(021) 8758614',
                'email' => 'dp3ap2kb@bogorkab.go.id'
            ],
            'DPKP' => [
                'kode' => 'DPKP',
                'nama' => 'Dinas Perumahan, Kawasan Permukiman dan Pertanahan',
                'telepon' => '(021) 8758615',
                'email' => 'dpkp@bogorkab.go.id'
            ],
            'DPMD' => [
                'kode' => 'DPMD',
                'nama' => 'Dinas Pemberdayaan Masyarakat dan Desa',
                'telepon' => '(021) 8758616',
                'email' => 'dpmd@bogorkab.go.id'
            ],
            'DPMPTSP' => [
                'kode' => 'DPMPTSP',
                'nama' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                'telepon' => '(021) 8758617',
                'email' => 'dpmptsp@bogorkab.go.id'
            ],
            'DPTR' => [
                'kode' => 'DPTR',
                'nama' => 'Dinas Pertanahan dan Tata Ruang',
                'telepon' => '(021) 8758618',
                'email' => 'dptr@bogorkab.go.id'
            ],
            'DPU' => [
                'kode' => 'PUPR', // Pertahankan kode PUPR untuk ID 5
                'nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'telepon' => '(021) 8758603',
                'email' => 'pupr@bogorkab.go.id'
            ],
            'INSPEKTORAT' => [
                'kode' => 'INSPEKTORAT',
                'nama' => 'Inspektorat Daerah',
                'telepon' => '(021) 8758602',
                'email' => 'inspektorat@bogorkab.go.id'
            ],
            'RSUD CIAWI' => [
                'kode' => 'RSUD Ciawi',
                'nama' => 'Rumah Sakit Umum Daerah Ciawi',
                'telepon' => '(0251) 8240797',
                'email' => 'rsudciawi@bogorkab.go.id',
                'alamat' => 'Jl. Raya Puncak No.479, Bendungan, Kec. Ciawi, Kabupaten Bogor 16720'
            ],
            'RSUD CIBINONG' => [
                'kode' => 'RSUD Cibinong',
                'nama' => 'Rumah Sakit Umum Daerah Cibinong',
                'telepon' => '(021) 8753482',
                'email' => 'rsudcibinong@bogorkab.go.id'
            ],
            'RSUD CILEUNGSI' => [
                'kode' => 'RSUD Cileungsi',
                'nama' => 'Rumah Sakit Umum Daerah Cileungsi',
                'telepon' => '(021) 89934666',
                'email' => 'rsudcileungsi@bogorkab.go.id'
            ],
            'RSUD LEUWILIANG' => [
                'kode' => 'RSUD Leuwiliang',
                'nama' => 'Rumah Sakit Umum Daerah Leuwiliang',
                'telepon' => '(0251) 8643291',
                'email' => 'rsudleuwiliang@bogorkab.go.id',
                'alamat' => 'Jl. Raya Cibeber No.1, Leuwiliang, Kec. Leuwiliang, Kabupaten Bogor 16640'
            ],
            'SATPOLPP' => [
                'kode' => 'SATPOL PP',
                'nama' => 'Satuan Polisi Pamong Praja',
                'telepon' => '(021) 8758601',
                'email' => 'satpolpp@bogorkab.go.id'
            ],
            'SETDA' => [
                'kode' => 'SETDA',
                'nama' => 'Sekretariat Daerah',
                'telepon' => '(021) 8758600',
                'email' => 'setda@bogorkab.go.id'
            ],
            'SETWAN' => [
                'kode' => 'SETWAN',
                'nama' => 'Sekretariat DPRD',
                'telepon' => '(021) 8758605',
                'email' => 'setwan@bogorkab.go.id'
            ],
        ];

        // 2. Helper Normalisasi GPS
        $sanitizeLat = function ($raw) {
            if (!$raw) return null;
            $str = trim((string)$raw);
            if (substr_count($str, '.') === 1) {
                $num = floatval($str);
                if (!is_nan($num) && $num < 0 && $num > -10) return number_format($num, 6, '.', '');
            }
            $digits = preg_replace('/[^0-9]/', '', $str);
            if (empty($digits)) return null;
            $val = floatval(preg_replace('/^6/', '-6.', $digits));
            return number_format($val, 6, '.', '');
        };

        $sanitizeLong = function ($raw) {
            if (!$raw) return null;
            $str = trim((string)$raw);
            if (substr_count($str, '.') === 1) {
                $num = floatval($str);
                if (!is_nan($num) && $num > 100 && $num < 115) return number_format($num, 6, '.', '');
            }
            $digits = preg_replace('/[^0-9]/', '', $str);
            if (empty($digits)) return null;
            if (str_starts_with($digits, '106')) {
                $val = floatval(preg_replace('/^106/', '106.', $digits));
            } elseif (str_starts_with($digits, '107')) {
                $val = floatval(preg_replace('/^107/', '107.', $digits));
            } else {
                $val = floatval('106.' . ltrim($digits, '10'));
            }
            return number_format($val, 6, '.', '');
        };

        // 3. Seed Master Data Dinas (38 Dinas/Badan/SKPD/RSUD dari app_md_lokasidinas.csv)
        $csvPath = public_path('app_md_lokasidinas.csv');
        if (file_exists($csvPath)) {
            $lines = file($csvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (count($lines) > 1) {
                foreach (array_slice($lines, 1) as $line) {
                    $cols = str_getcsv($line);
                    if (count($cols) >= 4) {
                        $csvKey = strtoupper(trim($cols[0]));
                        $meta = $agencyMeta[$csvKey] ?? null;

                        $kode = $meta ? $meta['kode'] : $csvKey;
                        $nama = $meta ? $meta['nama'] : trim($cols[0]);
                        $alamat = !empty($meta['alamat']) ? $meta['alamat'] : trim($cols[1]);
                        $telepon = $meta['telepon'] ?? null;
                        $email = $meta['email'] ?? null;

                        $lat = $sanitizeLat($cols[2]);
                        $long = $sanitizeLong($cols[3]);

                        $dataToSave = [
                            'nama_dinas' => $nama,
                            'alamat' => $alamat,
                            'gps_lat' => $lat,
                            'gps_long' => $long,
                            'updated_at' => $now,
                        ];

                        if ($telepon) $dataToSave['telepon'] = $telepon;
                        if ($email) $dataToSave['email'] = $email;

                        DB::table('sirapi_md_dinas')->updateOrInsert(
                            ['kode_dinas' => $kode],
                            $dataToSave
                        );
                    }
                }
            }
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
