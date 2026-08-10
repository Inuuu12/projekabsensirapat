<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Wajah Pegawai - SIRAPI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-sangatmuda': '#DCF1E6',
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
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex flex-col items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-lg relative space-y-6 text-center">
            <a href="{{ route('publik.presensi.pegawai', $routeParams) }}" class="absolute top-6 left-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors" title="Kembali">
                &larr;
            </a>

            <div class="space-y-1 pt-2">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Scan Wajah Pegawai</h1>
                <p class="text-xs text-gray-500 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
            </div>

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center space-y-3 my-4">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 leading-relaxed">Presensi Face Recognition untuk agenda ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @else
                <div class="relative w-full max-w-md mx-auto aspect-[4/3] bg-gray-900 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center" id="video-container">
                    <p id="status-text" class="text-white text-sm font-medium absolute z-10 animate-pulse">Memuat model kecerdasan buatan...</p>
                    <video id="video" class="absolute top-0 left-0 w-full h-full object-cover hidden" autoplay muted playsinline></video>
                    <canvas id="overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none"></canvas>
                    
                    <div id="success-overlay" class="absolute inset-0 bg-ijo-tua/90 z-30 flex flex-col items-center justify-center text-white hidden">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-ijo-tua mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h2 class="text-xl font-bold" id="success-name">Bagus Wihandono</h2>
                        <p class="text-sm mt-2 font-medium">Presensi Berhasil Dicatat!</p>
                    </div>
                </div>

                <p class="text-xs text-gray-500">Posisikan wajah Anda di tengah kamera hingga sistem mengenali Anda.</p>
            @endif
        </div>
    </main>

    @include('publik.layout_publik.footer')

    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const video = document.getElementById('video');
            const overlay = document.getElementById('overlay');
            const statusText = document.getElementById('status-text');
            const successOverlay = document.getElementById('success-overlay');
            const successName = document.getElementById('success-name');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const agendaId = "{{ $agendaAktif?->id_agenda ?? '' }}";
            let faceMatcher = null;
            let detectionInterval = null;
            let isScanning = true;

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
                clearInterval(detectionInterval);
                
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
                        alert(result.message);
                        isScanning = true;
                        successOverlay.classList.add('hidden');
                    } else {
                        setTimeout(() => {
                            window.location.href = result.redirect_url || "{{ route('pegawai.presensi.index', $routeParams) }}";
                        }, 2500);
                    }
                } catch (e) {
                    alert('Terjadi kesalahan koneksi.');
                    isScanning = true;
                    successOverlay.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>
