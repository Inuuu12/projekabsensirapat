<!-- MODAL PREVIEW FOTO GALERI DENGAN DRAGGABLE PAN & ZOOM IN / ZOOM OUT -->
<div id="modal-preview-foto" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/85 backdrop-blur-xs p-2 sm:p-4 md:p-6 transition-all duration-200" onclick="handleImageModalClick(event)">
    <div class="relative flex flex-col w-full max-w-5xl max-h-[calc(100dvh-1rem)] sm:max-h-[92vh] rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43] overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="rounded-t-2xl bg-[#3f8078] dark:bg-[#163830] text-white px-3.5 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between gap-2.5 sm:gap-3 shrink-0 border-b border-white/10 select-none">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <span class="text-lg sm:text-xl shrink-0">🖼️</span>
                <div class="min-w-0">
                    <h3 id="foto-preview-title" class="text-xs sm:text-base font-bold text-white truncate leading-tight">Preview Foto Galeri</h3>
                    <p id="foto-preview-date" class="text-[10px] sm:text-[11px] text-white/75 truncate mt-0.5">-</p>
                </div>
            </div>

            <!-- Tombol Aksi Header: Zoom Controls, Download, Close -->
            <div class="flex items-center gap-1 sm:gap-1.5 shrink-0">
                <!-- Zoom Out -->
                <button id="foto-btn-zoom-out" type="button" onclick="zoomImage(-0.25)" class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white transition backdrop-blur-xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white/15" title="Perkecil (Minimal 100%)">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </button>

                <!-- Zoom In -->
                <button id="foto-btn-zoom-in" type="button" onclick="zoomImage(0.25)" class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white transition backdrop-blur-xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white/15" title="Perbesar (Zoom In)">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </button>

                <!-- Reset Zoom -->
                <button type="button" onclick="resetImageZoom()" class="flex h-8 px-2 sm:px-2.5 items-center justify-center rounded-lg bg-white/15 hover:bg-white/25 text-white text-[10px] sm:text-xs font-bold transition backdrop-blur-xs cursor-pointer" title="Reset Ukuran & Posisi (100%)">
                    <span id="foto-preview-scale">100%</span>
                </button>

                <!-- Unduh -->
                <a id="foto-preview-download" href="#" target="_blank" download class="inline-flex items-center gap-1.5 rounded-lg bg-white/15 hover:bg-white/25 px-2.5 sm:px-3 py-1.5 text-xs font-bold text-white transition backdrop-blur-xs" title="Unduh foto">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path>
                    </svg>
                    <span class="hidden sm:inline">Unduh</span>
                </a>

                <!-- Tutup -->
                <button type="button" onclick="closeImagePreview()" class="flex h-8 w-8 items-center justify-center rounded-full text-white/80 transition hover:bg-white/20 hover:text-white cursor-pointer ml-1" aria-label="Tutup preview">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Body Konten Preview Image: Drag & Pan Viewport -->
        <div id="foto-preview-container" class="relative flex-1 overflow-hidden min-h-[300px] sm:min-h-[420px] max-h-[calc(100dvh-75px)] sm:max-h-[calc(92vh-65px)] bg-gray-950 dark:bg-[#091210] flex items-center justify-center p-2 sm:p-4 select-none touch-none cursor-default">
            <img id="foto-preview-img" 
                 src="" 
                 alt="Preview Foto" 
                 ondragstart="return false;"
                 class="max-h-[62dvh] sm:max-h-[72vh] max-w-[95%] sm:max-w-[90%] rounded-xl object-contain shadow-2xl origin-center will-change-transform select-none pointer-events-auto">
        </div>
        
        <div class="px-4 py-2 bg-gray-900/60 dark:bg-[#0d1c18] border-t border-white/5 flex items-center justify-between text-[11px] text-gray-400 select-none">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="hidden sm:inline">Tips: Geser foto dengan mouse saat diperbesar, atau gunakan scroll wheel untuk zoom.</span>
                <span class="sm:hidden">Tips: Geser foto saat zoom.</span>
            </span>
            <span id="foto-preview-hint" class="font-medium text-emerald-400/80">Skala 100%</span>
        </div>
    </div>
</div>

<script>
    let photoCurrentScale = 1.0;
    const photoMinScale = 1.0;
    const photoMaxScale = 3.5;
    let photoTranslateX = 0;
    let photoTranslateY = 0;

    let isDraggingPhoto = false;
    let photoStartX = 0;
    let photoStartY = 0;
    let photoLastTranslateX = 0;
    let photoLastTranslateY = 0;

    function openImagePreview(url, title = 'Dokumentasi Kegiatan', date = '-') {
        const modal = document.getElementById('modal-preview-foto');
        const img = document.getElementById('foto-preview-img');
        const titleEl = document.getElementById('foto-preview-title');
        const dateEl = document.getElementById('foto-preview-date');
        const downloadBtn = document.getElementById('foto-preview-download');

        if (!modal || !url) return;

        if (titleEl) titleEl.textContent = title;
        if (dateEl) dateEl.textContent = date;
        if (downloadBtn) {
            downloadBtn.href = url;
            const safeName = (title || 'foto-galeri').replace(/[^a-zA-Z0-9_-]/g, '_');
            downloadBtn.setAttribute('download', safeName + '.jpg');
        }
        if (img) {
            img.src = url;
            resetImageZoom();
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImagePreview() {
        const modal = document.getElementById('modal-preview-foto');
        if (!modal) return;
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function handleImageModalClick(e) {
        if (e.target.id === 'modal-preview-foto') {
            closeImagePreview();
        }
    }

    function zoomImage(delta) {
        const newScale = Math.min(Math.max(photoCurrentScale + delta, photoMinScale), photoMaxScale);
        if (newScale === photoCurrentScale) return;
        photoCurrentScale = newScale;
        if (photoCurrentScale <= photoMinScale) {
            photoTranslateX = 0;
            photoTranslateY = 0;
        }
        applyPhotoTransform(true);
    }

    function resetImageZoom() {
        photoCurrentScale = 1.0;
        photoTranslateX = 0;
        photoTranslateY = 0;
        applyPhotoTransform(true);
    }

    function applyPhotoTransform(smooth = true) {
        const img = document.getElementById('foto-preview-img');
        const container = document.getElementById('foto-preview-container');
        const scaleEl = document.getElementById('foto-preview-scale');
        const hintEl = document.getElementById('foto-preview-hint');
        const btnZoomOut = document.getElementById('foto-btn-zoom-out');
        const btnZoomIn = document.getElementById('foto-btn-zoom-in');

        if (!img) return;

        if (photoCurrentScale <= photoMinScale) {
            photoCurrentScale = photoMinScale;
            photoTranslateX = 0;
            photoTranslateY = 0;
            if (container) container.style.cursor = 'default';
        } else {
            if (container) container.style.cursor = isDraggingPhoto ? 'grabbing' : 'grab';
        }

        img.style.transition = smooth ? 'transform 0.18s cubic-bezier(0.16, 1, 0.3, 1)' : 'none';
        img.style.transform = `translate(${photoTranslateX}px, ${photoTranslateY}px) scale(${photoCurrentScale})`;

        const percentText = `${Math.round(photoCurrentScale * 100)}%`;
        if (scaleEl) scaleEl.textContent = percentText;
        if (hintEl) hintEl.textContent = `Skala ${percentText}`;

        if (btnZoomOut) btnZoomOut.disabled = (photoCurrentScale <= photoMinScale);
        if (btnZoomIn) btnZoomIn.disabled = (photoCurrentScale >= photoMaxScale);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('foto-preview-container');
        const img = document.getElementById('foto-preview-img');

        if (container) {
            // Wheel Zoom
            container.addEventListener('wheel', (e) => {
                const modal = document.getElementById('modal-preview-foto');
                if (modal && !modal.classList.contains('hidden')) {
                    e.preventDefault();
                    zoomImage(e.deltaY < 0 ? 0.2 : -0.2);
                }
            }, { passive: false });

            // Drag Start (Mouse & Touch)
            const startDrag = (clientX, clientY) => {
                if (photoCurrentScale <= photoMinScale) return;
                isDraggingPhoto = true;
                photoStartX = clientX;
                photoStartY = clientY;
                photoLastTranslateX = photoTranslateX;
                photoLastTranslateY = photoTranslateY;
                container.style.cursor = 'grabbing';
            };

            // Drag Move
            const moveDrag = (clientX, clientY) => {
                if (!isDraggingPhoto || photoCurrentScale <= photoMinScale) return;
                const deltaX = clientX - photoStartX;
                const deltaY = clientY - photoStartY;

                // Hitung batas pan berdasarkan kontainer
                const boundX = (container.clientWidth * (photoCurrentScale - 1)) / 1.5 + 80;
                const boundY = (container.clientHeight * (photoCurrentScale - 1)) / 1.5 + 80;

                photoTranslateX = Math.max(-boundX, Math.min(boundX, photoLastTranslateX + deltaX));
                photoTranslateY = Math.max(-boundY, Math.min(boundY, photoLastTranslateY + deltaY));

                applyPhotoTransform(false);
            };

            // Drag End
            const endDrag = () => {
                if (isDraggingPhoto) {
                    isDraggingPhoto = false;
                    container.style.cursor = photoCurrentScale > photoMinScale ? 'grab' : 'default';
                    applyPhotoTransform(true);
                }
            };

            // Mouse Events
            container.addEventListener('mousedown', (e) => {
                startDrag(e.clientX, e.clientY);
                e.preventDefault();
            });
            window.addEventListener('mousemove', (e) => {
                moveDrag(e.clientX, e.clientY);
            });
            window.addEventListener('mouseup', endDrag);

            // Touch Events (Mobile Support)
            container.addEventListener('touchstart', (e) => {
                if (e.touches.length === 1) {
                    startDrag(e.touches[0].clientX, e.touches[0].clientY);
                }
            }, { passive: true });

            container.addEventListener('touchmove', (e) => {
                if (e.touches.length === 1) {
                    moveDrag(e.touches[0].clientX, e.touches[0].clientY);
                }
            }, { passive: true });

            container.addEventListener('touchend', endDrag);

            // Double Click to Toggle Zoom
            container.addEventListener('dblclick', (e) => {
                if (photoCurrentScale > 1.0) {
                    resetImageZoom();
                } else {
                    zoomImage(1.0);
                }
            });
        }
    });
</script>
