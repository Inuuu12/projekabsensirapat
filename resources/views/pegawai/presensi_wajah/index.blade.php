<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Wajah Pegawai - RAPID</title>
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
        @keyframes biometricScan {
            0% {
                top: 5%;
                opacity: 0.2;
            }
            20% {
                opacity: 1;
            }
            80% {
                opacity: 1;
            }
            100% {
                top: 90%;
                opacity: 0.2;
            }
        }
        .biometric-laser-line {
            position: absolute;
            left: 4%;
            right: 4%;
            height: 2.5px;
            background: linear-gradient(90deg, transparent 0%, rgba(52, 211, 153, 0.7) 15%, #10b981 50%, rgba(52, 211, 153, 0.7) 85%, transparent 100%);
            box-shadow: 0 0 12px 2.5px rgba(16, 185, 129, 0.85), 0 0 4px rgba(255, 255, 255, 0.95);
            animation: biometricScan 2s ease-in-out infinite alternate;
            pointer-events: none;
            z-index: 25;
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

        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-xl p-6 md:p-8 max-w-2xl w-full shadow-lg relative space-y-6 text-center transition-colors">
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
                    
                    <!-- Target Face Guide Frame -->
                    <div id="face-guide-frame" class="absolute inset-0 z-20 pointer-events-none flex items-center justify-center hidden">
                        <div id="face-guide-box" class="relative w-[56%] h-[74%] rounded-[36px] border-2 border-dashed border-white/70 shadow-[0_0_0_9999px_rgba(0,0,0,0.38)] transition-all duration-300 flex flex-col justify-between items-center p-2.5 overflow-hidden">
                            <!-- Laser scan bar -->
                            <div id="biometric-laser" class="biometric-laser-line hidden"></div>

                            <!-- Corner guides -->
                            <div class="w-full flex justify-between z-10">
                                <span class="guide-corner w-4 h-4 border-t-3 border-l-3 border-white rounded-tl-xl transition-colors"></span>
                                <span class="guide-corner w-4 h-4 border-t-3 border-r-3 border-white rounded-tr-xl transition-colors"></span>
                            </div>
                            <span id="face-guide-hint" class="bg-black/65 backdrop-blur-xs text-white text-[10.5px] font-bold px-3 py-1 rounded-full text-center tracking-wide transition-colors z-10">Arahkan Wajah ke Bingkai</span>
                            <div class="w-full flex justify-between z-10">
                                <span class="guide-corner w-4 h-4 border-b-3 border-l-3 border-white rounded-bl-xl transition-colors"></span>
                                <span class="guide-corner w-4 h-4 border-b-3 border-r-3 border-white rounded-br-xl transition-colors"></span>
                            </div>
                        </div>
                    </div>

                    <div id="success-overlay" class="absolute inset-0 bg-ijo-tua/90 dark:bg-[#107050]/90 z-30 flex flex-col items-center justify-center text-white hidden">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-ijo-tua mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h2 class="text-xl font-bold" id="success-name">Bagus Wihandono</h2>
                        <p class="text-sm mt-2 font-medium px-4 text-center" id="success-msg">Presensi Berhasil Dicatat!</p>
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

                <p class="text-xs text-gray-500 dark:text-gray-400">Posisikan wajah Anda di dalam bingkai hingga sistem mengenali Anda.</p>
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

            const faceGuideFrame = document.getElementById('face-guide-frame');
            const faceGuideBox = document.getElementById('face-guide-box');
            const faceGuideHint = document.getElementById('face-guide-hint');
            const biometricLaser = document.getElementById('biometric-laser');
            const cornerAccents = document.querySelectorAll('.guide-corner');

            function getGuideBoxRoi(guideBoxEl, videoEl, displaySize) {
                if (!guideBoxEl || !videoEl) {
                    return {
                        x: displaySize.width * 0.22,
                        y: displaySize.height * 0.13,
                        width: displaySize.width * 0.56,
                        height: displaySize.height * 0.74
                    };
                }
                const boxRect = guideBoxEl.getBoundingClientRect();
                const videoRect = videoEl.getBoundingClientRect();

                if (videoRect.width <= 0 || videoRect.height <= 0) {
                    return {
                        x: displaySize.width * 0.22,
                        y: displaySize.height * 0.13,
                        width: displaySize.width * 0.56,
                        height: displaySize.height * 0.74
                    };
                }

                const leftPercent = Math.max(0, (boxRect.left - videoRect.left) / videoRect.width);
                const topPercent = Math.max(0, (boxRect.top - videoRect.top) / videoRect.height);
                const widthPercent = Math.min(1, boxRect.width / videoRect.width);
                const heightPercent = Math.min(1, boxRect.height / videoRect.height);

                return {
                    x: leftPercent * displaySize.width,
                    y: topPercent * displaySize.height,
                    width: widthPercent * displaySize.width,
                    height: heightPercent * displaySize.height
                };
            }

            function checkFaceInRoi(detection, roi) {
                const b = detection.detection.box;
                const landmarks = detection.landmarks ? detection.landmarks.positions : null;

                // Abaikan jika wajah terlalu kecil (orang di belakang)
                if (b.width < roi.width * 0.28 || b.height < roi.height * 0.28) {
                    return { isFull: false, isCutting: false, reason: 'too_small' };
                }

                // Toleransi batas tepi border agar wajah harus benar-benar di dalam
                const pad = 4;
                const roiLeft = roi.x + pad;
                const roiRight = roi.x + roi.width - pad;
                const roiTop = roi.y + pad;
                const roiBottom = roi.y + roi.height - pad;

                // 1. Seluruh kotak wajah harus berada di dalam batas bingkai
                const isBoxInside = (
                    b.x >= roiLeft &&
                    (b.x + b.width) <= roiRight &&
                    b.y >= roiTop &&
                    (b.y + b.height) <= roiBottom
                );

                // 2. Seluruh 68 titik biometrik (dagu, rahang, alis, mata) harus berada di dalam bingkai
                let areLandmarksInside = true;
                if (landmarks && landmarks.length > 0) {
                    for (let i = 0; i < landmarks.length; i++) {
                        const p = landmarks[i];
                        if (p.x < roiLeft || p.x > roiRight || p.y < roiTop || p.y > roiBottom) {
                            areLandmarksInside = false;
                            break;
                        }
                    }
                }

                if (isBoxInside && areLandmarksInside) {
                    return { isFull: true, isCutting: false };
                }

                // Cek apakah sebagian wajah memotong/mengenai batas bingkai
                const isOverlapping = (
                    (b.x + b.width) > roi.x &&
                    b.x < (roi.x + roi.width) &&
                    (b.y + b.height) > roi.y &&
                    b.y < (roi.y + roi.height)
                );

                if (isOverlapping) {
                    return { isFull: false, isCutting: true };
                }

                return { isFull: false, isCutting: false };
            }

            function setGuideFrameActive(state) {
                if (!faceGuideBox || !faceGuideHint) return;

                // Reset styling classes
                faceGuideBox.classList.remove(
                    'border-white/70', 'border-dashed',
                    'border-emerald-400', 'border-amber-400', 'border-solid',
                    'shadow-[0_0_0_9999px_rgba(0,0,0,0.38)]',
                    'shadow-[0_0_0_9999px_rgba(0,0,0,0.38),0_0_25px_rgba(16,185,129,0.5)]',
                    'shadow-[0_0_0_9999px_rgba(0,0,0,0.38),0_0_20px_rgba(245,158,11,0.4)]'
                );
                faceGuideHint.classList.remove('bg-black/65', 'bg-emerald-600', 'bg-amber-600', 'text-white');
                cornerAccents.forEach(el => el.classList.remove('border-white', 'border-emerald-400', 'border-amber-400'));

                if (state === 'valid' || state === true) {
                    faceGuideBox.classList.add('border-emerald-400', 'border-solid', 'shadow-[0_0_0_9999px_rgba(0,0,0,0.38),0_0_25px_rgba(16,185,129,0.5)]');
                    faceGuideHint.classList.add('bg-emerald-600', 'text-white');
                    faceGuideHint.textContent = "Wajah Pas, Memindai...";
                    if (biometricLaser) biometricLaser.classList.remove('hidden');
                    cornerAccents.forEach(el => el.classList.add('border-emerald-400'));
                } else if (state === 'cutting') {
                    faceGuideBox.classList.add('border-amber-400', 'border-solid', 'shadow-[0_0_0_9999px_rgba(0,0,0,0.38),0_0_20px_rgba(245,158,11,0.4)]');
                    faceGuideHint.classList.add('bg-amber-600', 'text-white');
                    faceGuideHint.textContent = "Posisikan Seluruh Wajah di Dalam Bingkai";
                    if (biometricLaser) biometricLaser.classList.add('hidden');
                    cornerAccents.forEach(el => el.classList.add('border-amber-400'));
                } else {
                    // 'idle' / 'outside'
                    faceGuideBox.classList.add('border-white/70', 'border-dashed', 'shadow-[0_0_0_9999px_rgba(0,0,0,0.38)]');
                    faceGuideHint.classList.add('bg-black/65', 'text-white');
                    faceGuideHint.textContent = "Arahkan Wajah ke Bingkai";
                    if (biometricLaser) biometricLaser.classList.add('hidden');
                    cornerAccents.forEach(el => el.classList.add('border-white'));
                }
            }

            function drawBiometricLandmarks(ctx, targetFace) {
                if (!targetFace || !targetFace.landmarks) return;
                const points = targetFace.landmarks.positions;
                ctx.save();
                
                // Gambar 68 cyber dots biometrik
                ctx.fillStyle = '#34d399';
                ctx.shadowColor = '#10b981';
                ctx.shadowBlur = 6;
                for (let i = 0; i < points.length; i++) {
                    ctx.beginPath();
                    ctx.arc(points[i].x, points[i].y, 2, 0, 2 * Math.PI);
                    ctx.fill();
                }

                // Gambar garis kontur biometrik halus
                ctx.strokeStyle = 'rgba(52, 211, 153, 0.45)';
                ctx.lineWidth = 1.2;

                const segments = [
                    targetFace.landmarks.getJawOutline(),
                    targetFace.landmarks.getLeftEyeBrow(),
                    targetFace.landmarks.getRightEyeBrow(),
                    targetFace.landmarks.getNose(),
                    targetFace.landmarks.getLeftEye(),
                    targetFace.landmarks.getRightEye(),
                    targetFace.landmarks.getMouth()
                ];

                for (const segment of segments) {
                    if (segment && segment.length > 0) {
                        ctx.beginPath();
                        ctx.moveTo(segment[0].x, segment[0].y);
                        for (let i = 1; i < segment.length; i++) {
                            ctx.lineTo(segment[i].x, segment[i].y);
                        }
                        if (segment === targetFace.landmarks.getLeftEye() || 
                            segment === targetFace.landmarks.getRightEye() || 
                            segment === targetFace.landmarks.getMouth()) {
                            ctx.closePath();
                        }
                        ctx.stroke();
                    }
                }
                ctx.restore();
            }

            function resumeScanning() {
                if (errorOverlay) errorOverlay.classList.add('hidden');
                if (successOverlay) successOverlay.classList.add('hidden');
                if (faceGuideFrame) faceGuideFrame.classList.remove('hidden');
                setGuideFrameActive(false);
                isScanning = true;
            }

            retryScanBtn?.addEventListener('click', resumeScanning);

            // Load Models
            try {
                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri('{{ asset('models') }}'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('{{ asset('models') }}'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('{{ asset('models') }}')
                ]);
                statusText.innerText = "Mengambil data pegawai...";
            } catch (err) {
                console.error("Gagal memuat model:", err);
                statusText.innerText = "Gagal memuat model. Periksa koneksi atau file model.";
                return;
            }

            // Fetch Registered Faces
            try {
                const response = await fetch('{{ route('api.pegawai.faces') }}');
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
                console.error("Gagal mengambil data pegawai:", err);
                statusText.innerText = "Gagal mengambil data pegawai.";
                return;
            }

            // Check Camera API support (requires HTTPS or localhost)
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                statusText.innerText = "Kamera tidak didukung pada koneksi ini. Pastikan menggunakan protokol HTTPS atau localhost.";
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
                if (faceGuideFrame) faceGuideFrame.classList.remove('hidden');
                statusText.classList.add('hidden');
            } catch (err) {
                console.error("Gagal akses kamera:", err);
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

                    const roi = getGuideBoxRoi(faceGuideBox, video, displaySize);

                    // Evaluasi setiap wajah terhadap ROI bingkai panduan
                    let validFace = null;
                    let hasCuttingFace = false;

                    for (const d of resizedDetections) {
                        const status = checkFaceInRoi(d, roi);
                        if (status.isFull) {
                            if (!validFace || (d.detection.box.width * d.detection.box.height) > (validFace.detection.box.width * validFace.detection.box.height)) {
                                validFace = d;
                            }
                        } else if (status.isCutting) {
                            hasCuttingFace = true;
                        }
                    }

                    if (!validFace) {
                        if (hasCuttingFace) {
                            setGuideFrameActive('cutting');
                        } else {
                            setGuideFrameActive('idle');
                        }
                        return;
                    }

                    // Wajah 100% full di dalam bingkai!
                    setGuideFrameActive('valid');

                    const bestMatch = faceMatcher.findBestMatch(validFace.descriptor);
                    
                    let labelText = "Tidak Dikenali";
                    let boxColor = "#ef4444";

                    if (bestMatch.label !== 'unknown') {
                        const matchData = JSON.parse(bestMatch.label);
                        labelText = matchData.name + ` (${Math.round((1 - bestMatch.distance) * 100)}%)`;
                        boxColor = "#10b981"; // emerald green
                        
                        if (isScanning && bestMatch.distance < 0.45) { // Strict check
                            if (faceGuideFrame) faceGuideFrame.classList.add('hidden');
                            handleSuccess(matchData.id, matchData.name);
                        }
                    }

                    // Gambar titik & jaring kontur biometrik wajah
                    drawBiometricLandmarks(ctx, validFace);

                    const box = validFace.detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, { label: labelText, boxColor: boxColor });
                    drawBox.draw(overlay);
                }, 200); // 5 FPS
            });

            let liveGpsAddress = sessionStorage.getItem('presensi_address_' + agendaId) 
                || sessionStorage.getItem('presensi_address_global') 
                || localStorage.getItem('presensi_address_latest') 
                || '';

            async function fetchLiveReverseGeocode(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                        headers: { 'Accept-Language': 'id-ID,id;q=0.9,en;q=0.8' }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        const addr = data.address || {};
                        const road = addr.road || addr.street || addr.neighbourhood || addr.suburb || addr.village || addr.city_district || '';
                        const district = addr.city_district || addr.district || addr.suburb || addr.town || addr.village || '';
                        const city = addr.city || addr.regency || addr.county || 'Kabupaten Bogor';
                        const state = addr.state || 'Jawa Barat';
                        return data.display_name ? data.display_name : [road, district, city, state].filter(Boolean).join(', ');
                    }
                } catch (e) {}

                try {
                    const res = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=id`);
                    if (res.ok) {
                        const data = await res.json();
                        return [data.locality, data.city, data.principalSubdivision, data.countryName].filter(Boolean).join(', ');
                    }
                } catch (e) {}

                return "Dinas Komunikasi dan Informasi Kabupaten Bogor, Jalan Tegar Beriman, Pakansari, Cibinong, Bogor, Jawa Barat, 16915, Indonesia";
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (pos) => {
                    const addr = await fetchLiveReverseGeocode(pos.coords.latitude, pos.coords.longitude);
                    if (addr) {
                        liveGpsAddress = addr;
                        sessionStorage.setItem('presensi_address_' + agendaId, addr);
                        localStorage.setItem('presensi_address_latest', addr);
                    }
                }, () => {}, { enableHighAccuracy: true, timeout: 8000 });
            }

            async function handleSuccess(idPegawai, namaPegawai) {
                isScanning = false;

                // Ambil snapshot foto wajah tepat saat scan berhasil di agenda ini
                let snapshotBase64 = null;
                try {
                    const snapCanvas = document.createElement('canvas');
                    snapCanvas.width = video.videoWidth || 640;
                    snapCanvas.height = video.videoHeight || 480;
                    const snapCtx = snapCanvas.getContext('2d');
                    // Cermin horizontal agar orientasi foto sama dengan tampilan di layar
                    snapCtx.translate(snapCanvas.width, 0);
                    snapCtx.scale(-1, 1);
                    snapCtx.drawImage(video, 0, 0, snapCanvas.width, snapCanvas.height);
                    snapshotBase64 = snapCanvas.toDataURL('image/jpeg', 0.85);
                } catch (snapErr) {
                    console.warn('Gagal mengambil snapshot kamera:', snapErr);
                }

                const trackedLokasi = liveGpsAddress 
                    || sessionStorage.getItem('presensi_address_' + agendaId) 
                    || sessionStorage.getItem('presensi_address_global') 
                    || localStorage.getItem('presensi_address_latest') 
                    || 'Dinas Komunikasi dan Informasi Kabupaten Bogor, Jalan Tegar Beriman, Pakansari, Cibinong, Bogor, Jawa Barat, 16915, Indonesia';
                
                // Show Success UI
                overlay.getContext('2d').clearRect(0, 0, overlay.width, overlay.height);
                successName.innerText = namaPegawai;
                successOverlay.classList.remove('hidden');
                successOverlay.classList.add('animate-bounce');

                // Send to backend with the captured snapshot photo
                try {
                    const res = await fetch('{{ route('api.presensi.face') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id_pegawai: idPegawai,
                            id_agenda: agendaId,
                            foto_scan: snapshotBase64,
                            lokasi_presensi: trackedLokasi
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
                        const successMsgEl = document.getElementById('success-msg');
                        if (successMsgEl) {
                            successMsgEl.innerText = result.already_present 
                                ? (result.message || 'Anda sudah melakukan presensi sebelumnya.') 
                                : 'Presensi Berhasil Dicatat!';
                        }
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

            window.addEventListener('beforeunload', () => {
                if (detectionInterval) clearInterval(detectionInterval);
                if (video && video.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                }
            });
        });
    </script>
</body>
</html>
