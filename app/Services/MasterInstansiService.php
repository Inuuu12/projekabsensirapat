<?php

namespace App\Services;

class MasterInstansiService
{
    /**
     * Dapatkan master jabatan dan bidang untuk kecamatan
     */
    public static function getKecamatanData(): array
    {
        return [
            'jabatan' => [
                'Camat',
                'Sekretaris Camat',
                'Kepala Seksi Pemerintahan',
                'Kepala Seksi Ketenteraman dan Ketertiban Umum',
                'Kepala Seksi Ekonomi dan Pembangunan',
                'Kepala Seksi Pendidikan dan Kesehatan',
                'Kepala Seksi Pemberdayaan Masyarakat',
                'Kepala Sub Bagian Umum dan Kepegawaian',
                'Kepala Sub Bagian Program dan Keuangan',
                'Analis Kebijakan',
                'Pranata Komputer',
                'Polisi Pamong Praja Kecamatan',
                'Pengadministrasi Umum',
                'Pengelola Keuangan',
                'Operator Pelayanan / SIKS-NG',
                'Pelaksana / Staf',
            ],
            'bidang' => [
                'Sekretariat Kecamatan',
                'Seksi Pemerintahan',
                'Seksi Ketenteraman dan Ketertiban Umum',
                'Seksi Ekonomi dan Pembangunan',
                'Seksi Pendidikan dan Kesehatan',
                'Seksi Pemberdayaan Masyarakat',
                'Sub Bagian Umum dan Kepegawaian',
                'Sub Bagian Program dan Keuangan',
            ],
        ];
    }

    /**
     * Dapatkan master data per Dinas/Badan berdasarkan ID Dinas
     */
    public static function getDinasData(int $idDinas): array
    {
        return match ($idDinas) {
            // 1: Diskominfo
            1 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala UPT',
                    'Sub Koordinator',
                    'Pranata Komputer Ahli Muda',
                    'Pranata Komputer Pertama',
                    'Pranata Humas',
                    'Analis Kebijakan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pengelolaan Informasi dan Komunikasi Publik',
                    'Bidang Aplikasi Informatika',
                    'Bidang Infrastruktur Teknologi',
                    'Bidang Persandian dan Statistik',
                    'UPT Radio dan Televisi',
                ],
            ],

            // 2: Dinas Pendidikan
            2 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Pengawas Sekolah',
                    'Penilik PAUD',
                    'Pamong Belajar',
                    'Guru Ahli',
                    'Kepala Sekolah',
                    'Analis Pendidikan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pembinaan PAUD dan Pendidikan Nonformal',
                    'Bidang Pembinaan Sekolah Dasar (SD)',
                    'Bidang Pembinaan Sekolah Menengah Pertama (SMP)',
                    'Bidang Pembinaan Tenaga Pendidik dan Kependidikan (PTK)',
                    'Sub Bagian Umum dan Kepegawaian',
                    'Sub Bagian Perencanaan dan Keuangan',
                ],
            ],

            // 3: Dinas Kesehatan
            3 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala Puskesmas',
                    'Dokter',
                    'Dokter Gigi',
                    'Bidan',
                    'Perawat',
                    'Apoteker',
                    'Epidemiolog Kesehatan',
                    'Sanitarian',
                    'Nutrisionis',
                    'Pranata Laboratorium Kesehatan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Kesehatan Masyarakat (Kesmas)',
                    'Bidang Pencegahan dan Pengendalian Penyakit (P2P)',
                    'Bidang Pelayanan Kesehatan (Yankes)',
                    'Bidang Sumber Daya Kesehatan (SDK)',
                    'UPT Puskesmas',
                    'UPT Laboratorium Kesehatan Daerah (Labkesda)',
                ],
            ],

            // 4: Dinas Perhubungan
            4 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala UPT PKB',
                    'Penguji Kendaraan Bermotor',
                    'Petugas Pengatur Lalu Lintas Jalan',
                    'Teknisi Sarana Prasarana Transportasi',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Lalu Lintas',
                    'Bidang Angkutan',
                    'Bidang Sarana dan Prasarana',
                    'Bidang Keselamatan Transportasi',
                    'UPT Pengujian Kendaraan Bermotor',
                ],
            ],

            // 5: Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)
            5 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala UPT Jalan dan Jembatan',
                    'Teknik Jalan dan Jembatan',
                    'Teknik Tata Bangunan dan Perumahan',
                    'Teknik Pengairan / SDA',
                    'Surveyor Pemetaan',
                    'Pengawas Konstruksi Lapangan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pembangunan Jalan dan Jembatan',
                    'Bidang Pemeliharaan Jalan dan Jembatan',
                    'Bidang Sumber Daya Air (SDA)',
                    'Bidang Penataan Bangunan',
                    'Bidang Jasa Konstruksi',
                    'UPT Jalan dan Jembatan',
                ],
            ],

            // 6: Bappedalitbang
            6 => [
                'jabatan' => [
                    'Kepala Badan',
                    'Sekretaris Badan',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Perencana Ahli Madya',
                    'Perencana Ahli Muda',
                    'Perencana Ahli Pertama',
                    'Peneliti',
                    'Perekayasa',
                    'Analis Kebijakan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Perencanaan, Pengendalian dan Evaluasi Pembangunan Daerah',
                    'Bidang Perekonomian dan Sumber Daya Alam',
                    'Bidang Pemerintahan dan Pembangunan Manusia',
                    'Bidang Infrastruktur dan Pengembangan Wilayah',
                    'Bidang Riset dan Inovasi Daerah',
                ],
            ],

            // 7: Bappenda (Badan Pengelolaan Pendapatan Daerah)
            7 => [
                'jabatan' => [
                    'Kepala Badan',
                    'Sekretaris Badan',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala UPT Pajak Daerah',
                    'Penilai PBB dan BPHTB',
                    'Pemeriksa Pajak Daerah',
                    'Pranata Keuangan / Pajak',
                    'Operator Sistem Informasi Pendapatan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Perencanaan dan Pengembangan Pendapatan',
                    'Bidang Pajak Daerah',
                    'Bidang Pengendalian dan Evaluasi Pendapatan',
                    'Bidang Pelayanan dan Penagihan Pajak',
                    'UPT Pajak Daerah',
                ],
            ],

            // 8: Satpol PP
            8 => [
                'jabatan' => [
                    'Kepala Satuan',
                    'Sekretaris Satuan',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Penyidik Pegawai Negeri Sipil (PPNS)',
                    'Polisi Pamong Praja Ahli',
                    'Polisi Pamong Praja Terampil / Pelaksana',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Ketenteraman dan Ketertiban Umum',
                    'Bidang Penegakan Peraturan Daerah',
                    'Bidang Perlindungan Masyarakat (Linmas)',
                    'Bidang Pembinaan Sumber Daya Manusia',
                ],
            ],

            // 10: Bakesbangpol
            10 => [
                'jabatan' => [
                    'Kepala Badan',
                    'Sekretaris Badan',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Analis Ketahanan Nasional',
                    'Analis Konflik Sosial',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Ideologi dan Kesatuan Bangsa',
                    'Bidang Politik Dalam Negeri dan Ormas',
                    'Bidang Ketahanan Ekonomi, Sosial dan Budaya',
                    'Bidang Kewaspadaan Dini dan Penanganan Konflik',
                ],
            ],

            // 11: BKPSDM
            11 => [
                'jabatan' => [
                    'Kepala Badan',
                    'Sekretaris Badan',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Analis SDM Aparatur',
                    'Asesor SDM Aparatur',
                    'Auditor Manajemen ASN',
                    'Pranata Komputer Kepegawaian',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pengadaan, Pemberhentian dan Informasi',
                    'Bidang Mutasi dan Promosi',
                    'Bidang Pengembangan Kompetensi Aparatur',
                    'Bidang Penilaian Kinerja Aparatur dan Penghargaan',
                ],
            ],

            // 12: BPBD
            12 => [
                'jabatan' => [
                    'Kepala Pelaksana',
                    'Sekretaris',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Analis Kebencanaan',
                    'Rescuer / Tim Reaksi Cepat (TRC)',
                    'Logistik dan Peralatan Kebencanaan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pencegahan dan Kesiapsiagaan',
                    'Bidang Kedaruratan dan Logistik',
                    'Bidang Rehabilitasi dan Rekonstruksi',
                ],
            ],

            // 13: BPKAD
            13 => [
                'jabatan' => [
                    'Kepala Badan',
                    'Sekretaris Badan',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Analis Keuangan Pusat dan Daerah',
                    'Pengelola Barang Milik Daerah (Aset)',
                    'Pranata Perbendaharaan dan Kas Daerah',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Anggaran',
                    'Bidang Perbendaharaan dan Kas Daerah',
                    'Bidang Akuntansi dan Pelaporan Keuangan',
                    'Bidang Pengelolaan Barang Milik Daerah',
                ],
            ],

            // 14: Dinas Pemadam Kebakaran
            14 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Komandan Sektor Damkar',
                    'Komandan Regu (Danru) Damkar',
                    'Petugas Pemadam Kebakaran',
                    'Petugas Penyelamatan (Rescue)',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pencegahan Kebakaran',
                    'Bidang Pemadaman dan Penyelamatan',
                    'Bidang Sarana dan Prasarana Damkar',
                    'Sektor Damkar Wilayah',
                ],
            ],

            // 15: Dinas Arsip dan Perpustakaan
            15 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Arsiparis Ahli/Terampil',
                    'Pustakawan Ahli/Terampil',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pengelolaan dan Akuisisi Arsip',
                    'Bidang Layanan, Otomasi dan Pembinaan Perpustakaan',
                ],
            ],

            // 16: Dinas Sosial
            16 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Pekerja Sosial Ahli/Terampil',
                    'Penyuluh Sosial',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pemberdayaan Sosial',
                    'Bidang Perlindungan dan Jaminan Sosial',
                    'Bidang Rehabilitasi Sosial',
                    'Bidang Penanganan Fakir Miskin',
                ],
            ],

            // 19: Disdukcapil
            19 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Administrator Database Kependudukan (ADB)',
                    'Operator SIAK',
                    'Analis Kebijakan Kependudukan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pelayanan Pendaftaran Penduduk',
                    'Bidang Pelayanan Pencatatan Sipil',
                    'Bidang Pengelolaan Informasi Administrasi Kependudukan (PIAK)',
                    'Bidang Pemanfaatan Data dan Inovasi Pelayanan',
                ],
            ],

            // 22: Disnaker
            22 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Pengantar Kerja',
                    'Mediator Hubungan Industrial',
                    'Instruktur Balai Latihan Kerja',
                    'Pengawas Ketenagakerjaan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Penempatan dan Perluasan Kerja',
                    'Bidang Hubungan Industrial dan Syarat Kerja',
                    'Bidang Pelatihan Vokasi dan Produktivitas',
                    'UPT Balai Latihan Kerja (BLK)',
                ],
            ],

            // 27: Dinas Lingkungan Hidup
            27 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Pengendali Dampak Lingkungan',
                    'Pengawas Lingkungan Hidup',
                    'Penyuluh Lingkungan Hidup',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Pengelolaan Sampah dan Limbah B3',
                    'Bidang Pengendalian Pencemaran dan Kerusakan Lingkungan',
                    'Bidang Tata Lingkungan dan Keanekaragaman Hayati',
                    'Bidang Penegakan Hukum Lingkungan',
                    'UPT Pengelolaan Sampah',
                ],
            ],

            // 31: DPMPTSP
            31 => [
                'jabatan' => [
                    'Kepala Dinas',
                    'Sekretaris Dinas',
                    'Kepala Bidang',
                    'Kepala Seksi',
                    'Penata Kelola Penanaman Modal',
                    'Analis Dokumen Perizinan',
                    'Customer Service / Front Office Perizinan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Penanaman Modal',
                    'Bidang Pelayanan Perizinan',
                    'Bidang Data, Pengawasan dan Pengaduan',
                ],
            ],

            // 33: Inspektorat
            33 => [
                'jabatan' => [
                    'Inspektur Daerah',
                    'Sekretaris Inspektorat',
                    'Inspektur Pembantu Wilayah',
                    'Auditor Ahli Madya',
                    'Auditor Ahli Muda',
                    'Auditor Ahli Pertama',
                    'Pengawas Penyelenggaraan Urusan Pemerintahan Daerah (PPUPD)',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Inspektorat Pembantu Wilayah I',
                    'Inspektorat Pembantu Wilayah II',
                    'Inspektorat Pembantu Wilayah III',
                    'Inspektorat Pembantu Wilayah IV',
                    'Inspektorat Pembantu Investigasi',
                ],
            ],

            // 34, 35, 36, 37: RSUD (Ciawi, Cibinong, Cileungsi, Leuwiliang)
            34, 35, 36, 37 => [
                'jabatan' => [
                    'Direktur RSUD',
                    'Wakil Direktur',
                    'Kepala Bagian',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Kepala Ruangan / Instalasi',
                    'Dokter Spesialis',
                    'Dokter Umum',
                    'Dokter Gigi',
                    'Perawat Ahli/Terampil',
                    'Bidan',
                    'Apoteker',
                    'Perekam Medis',
                    'Pranata Laboratorium Kesehatan',
                    'Radiografer',
                    'Fisioterapis',
                    'Pelaksana Administrasi Rumah Sakit',
                ],
                'bidang' => [
                    'Bagian Tata Usaha',
                    'Bidang Pelayanan Medik',
                    'Bidang Pelayanan Keperawatan',
                    'Bidang Penunjang Medik',
                    'Bagian Perencanaan dan Anggaran',
                    'Bagian Keuangan',
                ],
            ],

            // 38: Setda (Sekretariat Daerah)
            38 => [
                'jabatan' => [
                    'Sekretaris Daerah',
                    'Asisten Pemerintahan dan Kesejahteraan Rakyat',
                    'Asisten Perekonomian dan Pembangunan',
                    'Asisten Administrasi Umum',
                    'Kepala Bagian',
                    'Kepala Sub Bagian',
                    'Sub Koordinator',
                    'Analis Kebijakan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Bagian Tata Pemerintahan',
                    'Bagian Kesejahteraan Rakyat',
                    'Bagian Hukum',
                    'Bagian Perekonomian dan SDA',
                    'Bagian Administrasi Pembangunan',
                    'Bagian Pengadaan Barang dan Jasa',
                    'Bagian Umum',
                    'Bagian Protokol dan Komunikasi Pimpinan',
                    'Bagian Organisasi',
                ],
            ],

            // 39: Setwan (Sekretariat DPRD)
            39 => [
                'jabatan' => [
                    'Sekretaris DPRD',
                    'Kepala Bagian',
                    'Kepala Sub Bagian',
                    'Perisalah Legislatif',
                    'Analis Kebijakan',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Bagian Umum dan Keuangan',
                    'Bagian Persidangan dan Perundang-undangan',
                    'Bagian Fasilitasi Penganggaran dan Pengawasan',
                ],
            ],

            // Default OPD lainnya
            default => [
                'jabatan' => [
                    'Kepala Dinas / Kepala Badan',
                    'Sekretaris',
                    'Kepala Bidang',
                    'Kepala Sub Bagian / Kepala Seksi',
                    'Sub Koordinator',
                    'Analis Kebijakan',
                    'Pranata Komputer',
                    'Perencana',
                    'Pelaksana / Staf',
                ],
                'bidang' => [
                    'Sekretariat',
                    'Bidang Program dan Evaluasi',
                    'Bidang Teknis I',
                    'Bidang Teknis II',
                    'Bidang Teknis III',
                    'Sub Bagian Umum dan Kepegawaian',
                    'Sub Bagian Keuangan',
                ],
            ],
        };
    }

    /**
     * Dapatkan master jabatan dan bidang berdasarkan key instansi (e.g. 'dinas_1', 'kecamatan_3')
     */
    public static function getOptionsForInstansi(?string $instansiKey): array
    {
        if (empty($instansiKey)) {
            return [
                'jabatan' => [],
                'bidang' => [],
            ];
        }

        if (str_starts_with($instansiKey, 'kecamatan_')) {
            return self::getKecamatanData();
        }

        if (str_starts_with($instansiKey, 'dinas_')) {
            $idDinas = (int) substr($instansiKey, 6);
            return self::getDinasData($idDinas);
        }

        return self::getKecamatanData();
    }

    /**
     * Dapatkan seluruh data master instansi dalam format map siap-JSON untuk frontend
     */
    public static function getAllOptionsMap(iterable $dinasList, iterable $kecamatanList): array
    {
        $map = [];

        // Data untuk tiap dinas
        foreach ($dinasList as $dinas) {
            $id = $dinas->id_dinas ?? $dinas['id_dinas'];
            $map['dinas_' . $id] = self::getDinasData((int) $id);
        }

        // Data untuk kecamatan (seragam untuk semua kecamatan)
        $kecamatanData = self::getKecamatanData();
        foreach ($kecamatanList as $kec) {
            $id = $kec->id_kecamatan ?? $kec['id_kecamatan'];
            $map['kecamatan_' . $id] = $kecamatanData;
        }

        return $map;
    }
}
