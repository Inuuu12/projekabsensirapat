<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran Agenda - RAPID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
</head>
<body class="bg-black font-sans antialiased text-white flex flex-col min-h-screen">
    <main class="flex flex-1 flex-col overflow-hidden">
        <section id="standalone-container" class="flex flex-1 items-center justify-center overflow-hidden bg-black p-2 sm:p-4 select-none touch-none cursor-default">
            @if ($isImage)
                <img id="standalone-img" src="{{ $fileUrl }}" alt="Lampiran {{ $agenda->nama_agenda }}" ondragstart="return false;" class="max-h-[calc(100vh-100px)] max-w-[95%] object-contain rounded-lg origin-center will-change-transform select-none pointer-events-auto">
            @elseif ($isPdf)
                <iframe src="{{ $fileUrl }}#toolbar=1" title="Lampiran {{ $agenda->nama_agenda }}" class="h-[calc(100vh-84px)] w-full border-0 bg-white"></iframe>
            @else
                <div class="flex min-h-[calc(100vh-84px)] flex-col items-center justify-center gap-4 p-6 text-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-xs font-black uppercase text-white">
                        {{ $extension ?: 'file' }}
                    </div>
                    <p class="max-w-sm text-sm text-white/70">Preview file tidak tersedia di browser.</p>
                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center justify-center rounded-lg bg-white px-4 text-xs font-bold text-gray-900 transition hover:bg-gray-200">
                        Buka File
                    </a>
                </div>
            @endif
        </section>

        <div class="flex min-h-[74px] items-center justify-between border-t border-white/10 bg-black/90 px-4 sm:px-8 py-3.5 gap-3 shrink-0">
            <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="inline-flex h-9 sm:h-10 items-center justify-center rounded-lg bg-white/15 px-3.5 sm:px-4 text-xs font-bold text-white transition hover:bg-white/25">
                ← Detail
            </a>

            @if ($isImage)
                <div class="flex items-center gap-1 sm:gap-1.5">
                    <button type="button" onclick="zoomStandalone(-0.25)" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white transition cursor-pointer" title="Perkecil">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </button>
                    <button type="button" onclick="resetStandalone()" class="flex h-8 px-2.5 sm:h-9 sm:px-3 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition cursor-pointer" title="Reset (100%)">
                        <span id="standalone-scale">100%</span>
                    </button>
                    <button type="button" onclick="zoomStandalone(0.25)" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white transition cursor-pointer" title="Perbesar">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            @endif

            <a href="{{ $fileUrl }}" download class="inline-flex h-9 sm:h-10 items-center justify-center rounded-lg bg-ijo-tua px-3.5 sm:px-4 text-xs font-bold text-white transition hover:bg-ijo-semitua">
                Unduh
            </a>
        </div>
    </main>

    @if ($isImage)
    <script>
        let standScale = 1.0;
        let standTx = 0, standTy = 0;
        let standDragging = false;
        let standSx = 0, standSy = 0, standLastTx = 0, standLastTy = 0;

        function zoomStandalone(delta) {
            standScale = Math.min(Math.max(Number((standScale + delta).toFixed(2)), 1.0), 3.5);
            if (standScale <= 1.0) { standTx = 0; standTy = 0; }
            applyStandalone(true);
        }

        function resetStandalone() {
            standScale = 1.0; standTx = 0; standTy = 0;
            applyStandalone(true);
        }

        function applyStandalone(smooth = true) {
            const img = document.getElementById('standalone-img');
            const container = document.getElementById('standalone-container');
            const scaleEl = document.getElementById('standalone-scale');
            if (!img) return;
            if (container) container.style.cursor = standScale > 1.0 ? (standDragging ? 'grabbing' : 'grab') : 'default';
            img.style.transition = smooth ? 'transform 0.18s cubic-bezier(0.16, 1, 0.3, 1)' : 'none';
            img.style.transform = `translate(${standTx}px, ${standTy}px) scale(${standScale})`;
            if (scaleEl) scaleEl.textContent = `${Math.round(standScale * 100)}%`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('standalone-container');
            if (container) {
                container.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    zoomStandalone(e.deltaY < 0 ? 0.25 : -0.25);
                }, { passive: false });

                const startD = (x, y) => {
                    if (standScale <= 1.0) return;
                    standDragging = true;
                    standSx = x; standSy = y;
                    standLastTx = standTx; standLastTy = standTy;
                    container.style.cursor = 'grabbing';
                };

                const moveD = (x, y) => {
                    if (!standDragging || standScale <= 1.0) return;
                    const bx = (container.clientWidth * (standScale - 1)) / 1.5 + 60;
                    const by = (container.clientHeight * (standScale - 1)) / 1.5 + 60;
                    standTx = Math.max(-bx, Math.min(bx, standLastTx + (x - standSx)));
                    standTy = Math.max(-by, Math.min(by, standLastTy + (y - standSy)));
                    applyStandalone(false);
                };

                const endD = () => {
                    if (standDragging) {
                        standDragging = false;
                        container.style.cursor = standScale > 1.0 ? 'grab' : 'default';
                        applyStandalone(true);
                    }
                };

                container.addEventListener('mousedown', (e) => startD(e.clientX, e.clientY));
                window.addEventListener('mousemove', (e) => moveD(e.clientX, e.clientY));
                window.addEventListener('mouseup', endD);

                container.addEventListener('touchstart', (e) => {
                    if (e.touches.length === 1) startD(e.touches[0].clientX, e.touches[0].clientY);
                }, { passive: true });
                container.addEventListener('touchmove', (e) => {
                    if (e.touches.length === 1) moveD(e.touches[0].clientX, e.touches[0].clientY);
                }, { passive: true });
                container.addEventListener('touchend', endD);

                container.addEventListener('dblclick', () => {
                    if (standScale > 1.0) resetStandalone();
                    else zoomStandalone(1.0);
                });
            }
        });
    </script>
    @endif
</body>
</html>
