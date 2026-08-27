<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Wajah Pegawai - SIRAPI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('publik.layout.theme_script')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#35635b',
                        'ijo-semitua': '#2b4f49',
                        'ijo-sangatmuda': '#e3eeea',
                    }
                }
            }
        }
    </script>
    <style>
        video {
            transform: scaleX(-1);
        }
        canvas {
            transform: scaleX(-1);
        }
    </style>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex flex-col items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-lg relative space-y-6 text-center transition-colors">
            <a href="{{ route('publik.presensi.pegawai', $routeParams) }}" class="absolute top-6 left-6 w-8 h-8 rounded-full bg-gray-100 dark:bg-[#0f1c19] hover:bg-gray-200 dark:hover:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold transition-colors cursor-pointer" title="Kembali">
                &larr;
            </a>

            <div class="space-y-1 pt-2">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">Scan Wajah Pegawai</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
            </div>

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3 my-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Presensi Face Recognition untuk agenda ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->status_label === 'Mendatang')
                <div class="rounded-2xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/40 p-6 text-center space-y-3 my-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/60 text-blue-600 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-blue-900 dark:text-blue-200">Presensi Belum Dibuka (Terkunci)</h3>
                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 leading-relaxed">
                        Scanner wajah presensi untuk agenda ini masih terkunci dan baru aktif saat rapat dimulai pada pukul <strong>{{ substr((string) $agendaAktif->waktu, 0, 5) }} WIB</strong> ({{ $agendaAktif->tanggal?->translatedFormat('d F Y') }}).
                    </p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->isKuotaPenuh())
                <div class="rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-6 text-center space-y-3 my-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h3>
                    <p class="text-xs font-medium text-red-700 dark:text-red-300 leading-relaxed">Presensi Face Recognition untuk agenda ini telah ditutup karena kuota maksimal peserta telah terpenuhi.</p>
                </div>
            @else
                <div class="relative w-full max-w-md mx-auto aspect-[4/3] bg-gray-900 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center" id="video-container">
                    <p id="status-text" class="text-white text-sm font-medium absolute z-10 animate-pulse">Memuat model kecerdasan buatan...</p>
                    <video id="video" class="absolute top-0 left-0 w-full h-full object-cover hidden" autoplay muted playsinline></video>
                    <canvas id="overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none"></canvas>
                    
                    <div id="success-overlay" class="absolute inset-0 bg-ijo-tua/90 dark:bg-[#107050]/90 z-30 flex flex-col items-center justify-center text-white hidden">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-ijo-tua mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h2 class="text-xl font-bold" id="success-name">Bagus Wihandono</h2>
                        <p class="text-sm mt-2 font-medium">Presensi Berhasil Dicatat!</p>
                    </div>

                    <div id="error-overlay" class="absolute inset-0 bg-red-900/95 z-30 flex flex-col items-center justify-center text-white p-6 text-center hidden">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-600 mb-3 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <h2 class="text-sm font-bold" id="error-name">Nama Pegawai</h2>
                        <p class="text-xs mt-2 font-medium leading-relaxed max-w-sm" id="error-msg">Presensi Ditolak</p>
                        <button type="button" id="retry-scan-btn" class="mt-4 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-xs font-bold transition cursor-pointer">Coba Lagi</button>
                    </div>
                </div>

                <p class="text-xs text-gray-500 dark:text-gray-400">Posisikan wajah Anda di tengah kamera hingga sistem mengenali Anda.</p>
            @endif
        </div>
    </main>

    @include('publik.layout.footer')

    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const video = document.getElementById('video');
            const overlay = document.getElementById('overlay');
            const statusText = document.getElementById('status-text');
            const successOverlay = document.getElementById('success-overlay');
            const successName = document.getElementById('success-name');
            const errorOverlay = document.getElementById('error-overlay');
            const errorName = document.getElementById('error-name');
            const errorMsg = document.getElementById('error-msg');
            const retryScanBtn = document.getElementById('retry-scan-btn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const agendaId = "{{ $agendaAktif?->id_agenda ?? '' }}";
            let faceMatcher = null;
            let detectionInterval = null;
            let isScanning = true;

            function resumeScanning() {
                if (errorOverlay) errorOverlay.classList.add('hidden');
                if (successOverlay) successOverlay.classList.add('hidden');
                isScanning = true;
            }

            retryScanBtn?.addEventListener('click', resumeScanning);

            // Load Models
            try {
                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri('/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/models')
                ]);
                statusText.innerText = "Mengambil data pegawai...";
            } catch (err) {
                console.error(err);
                statusText.innerText = "Gagal memuat model. Periksa koneksi atau file model.";
                return;
            }

            // Fetch Registered Faces
            try {
                const response = await fetch('/api/pegawai/faces');
                const pegawaiList = await response.json();
                
                if (pegawaiList.length === 0) {
                    statusText.innerText = "Belum ada pegawai yang mendaftarkan wajah.";
                    return;
                }

                const labeledDescriptors = pegawaiList.map(pegawai => {
                    const descriptorArray = JSON.parse(pegawai.face_descriptor);
                    const float32Array = new Float32Array(descriptorArray);
                    return new faceapi.LabeledFaceDescriptors(
                        JSON.stringify({ id: pegawai.id_pegawai, name: pegawai.nama_pegawai }), 
                        [float32Array]
                    );
                });

                faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.45); // 0.45 is distance threshold (lower is stricter)
                statusText.innerText = "Menyalakan kamera...";
            } catch (err) {
                console.error(err);
                statusText.innerText = "Gagal mengambil data pegawai.";
                return;
            }

            // Start Camera
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "user",
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                });
                video.srcObject = stream;
                video.classList.remove('hidden');
                statusText.classList.add('hidden');
            } catch (err) {
                console.error(err);
                statusText.innerText = "Tidak dapat mengakses kamera. Pastikan izin kamera sudah diizinkan di browser HP Anda.";
                return;
            }

            video.addEventListener('play', () => {
                const displaySize = { width: video.videoWidth, height: video.videoHeight };
                faceapi.matchDimensions(overlay, displaySize);

                detectionInterval = setInterval(async () => {
                    if (!isScanning) return;

                    const detections = await faceapi.detectAllFaces(video, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                                                    .withFaceLandmarks()
                                                    .withFaceDescriptors();
                    
                    const resizedDetections = faceapi.resizeResults(detections, displaySize);
                    const ctx = overlay.getContext('2d');
                    ctx.clearRect(0, 0, overlay.width, overlay.height);

                    // faceapi.draw.drawDetections(overlay, resizedDetections);

                    for (const detection of resizedDetections) {
                        const bestMatch = faceMatcher.findBestMatch(detection.descriptor);
                        
                        // Draw box with name
                        let labelText = "Tidak Dikenali";
                        let boxColor = "red";

                        if (bestMatch.label !== 'unknown') {
                            const matchData = JSON.parse(bestMatch.label);
                            labelText = matchData.name + ` (${Math.round((1 - bestMatch.distance) * 100)}%)`;
                            boxColor = "#1F7A6F"; // ijo-semitua
                            
                            // Hit API and Stop
                            if (isScanning && bestMatch.distance < 0.45) { // Strict check
                                handleSuccess(matchData.id, matchData.name);
                            }
                        }

                        const box = detection.detection.box;
                        const drawBox = new faceapi.draw.DrawBox(box, { label: labelText, boxColor: boxColor });
                        drawBox.draw(overlay);
                    }
                }, 200); // 5 FPS
            });

            async function handleSuccess(idPegawai, namaPegawai) {
                isScanning = false;
                
                // Show Success UI
                overlay.getContext('2d').clearRect(0, 0, overlay.width, overlay.height);
                successName.innerText = namaPegawai;
                successOverlay.classList.remove('hidden');
                successOverlay.classList.add('animate-bounce');

                // Send to backend
                try {
                    const res = await fetch('/api/presensi/face', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id_pegawai: idPegawai,
                            id_agenda: agendaId
                        })
                    });
                    
                    const result = await res.json();
                    if (!result.success) {
                        successOverlay.classList.add('hidden');
                        if (errorOverlay && errorName && errorMsg) {
                            errorName.innerText = namaPegawai;
                            errorMsg.innerText = result.message || 'Presensi tidak dapat dilakukan.';
                            errorOverlay.classList.remove('hidden');
                        } else {
                            alert(result.message || 'Presensi ditolak.');
                            resumeScanning();
                        }
                    } else {
                        setTimeout(() => {
                            window.location.href = result.redirect_url || "{{ route('pegawai.presensi.index', $routeParams) }}";
                        }, 2500);
                    }
                } catch (e) {
                    successOverlay.classList.add('hidden');
                    alert('Terjadi kesalahan koneksi.');
                    resumeScanning();
                }
            }
        });
    </script>
</body>
</html>
