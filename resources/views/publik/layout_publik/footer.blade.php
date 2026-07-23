<footer class="bg-ijo-tua text-white mt-auto border-t border-white/10">
    <div class="container mx-auto px-4 md:px-12 py-10 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            
            <!-- Deskripsi Instansi -->
            <div class="space-y-3 md:col-span-2">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center font-bold text-sm">
                        🏛️
                    </div>
                    <span class="font-extrabold text-sm tracking-wide">Diskominfo Kab. Bogor</span>
                </div>
                <p class="text-xs text-gray-300 leading-relaxed pr-6">
                    Pusat informasi resmi, transparansi publik, dan pusat layanan transformasi digital Pemerintah Kabupaten Bogor.
                </p>
            </div>

            <!-- Navigasi Cepat -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-oren-muda">Menu Utama</h4>
                <ul class="space-y-2 text-xs text-gray-300">
                    <li><a href="{{ route('publik.beranda') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('publik.berita') }}" class="hover:text-white transition-colors">Berita Terkini</a></li>
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-white transition-colors">Agenda Kegiatan</a></li>
                    <li><a href="{{ route('publik.galeri') }}" class="hover:text-white transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('publik.video') }}" class="hover:text-white transition-colors">Dokumentasi Video</a></li>
                </ul>
            </div>

            <!-- Kontak & Layanan -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-oren-muda">Layanan & Feedback</h4>
                <ul class="space-y-2 text-xs text-gray-300">
                    <li><a href="{{ route('publik.masukan') }}" class="hover:text-white transition-colors">Formulir Masukan</a></li>
                    <li><a href="{{ route('publik.ulangtahun') }}" class="hover:text-white transition-colors">Info Ulang Tahun</a></li>
                    <li class="text-gray-400 pt-2">Email: info@bogorkab.go.id</li>
                </ul>
            </div>

        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-400 space-y-2 md:space-y-0">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi & Informatika Kabupaten Bogor. All rights reserved.</p>
            <p>Terhubung & Melayani dengan Hati</p>
        </div>
    </div>
</footer>