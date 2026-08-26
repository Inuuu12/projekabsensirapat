<!-- MODAL PREVIEW DOKUMEN / LAMPIRAN / NOTULEN / DOKUMENTASI -->
<div id="modal-preview-dokumen" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/75 backdrop-blur-xs p-2 sm:p-4 md:p-6 transition-all duration-200" onclick="handleDocModalClick(event)">
    <div class="relative flex flex-col w-full max-w-5xl max-h-[calc(100dvh-1rem)] sm:max-h-[92vh] rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43] overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="rounded-t-2xl bg-[#3f8078] dark:bg-[#163830] text-white px-3.5 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between gap-2.5 sm:gap-3 shrink-0 border-b border-white/10">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <span id="doc-preview-icon" class="text-lg sm:text-xl shrink-0">📄</span>
                <div class="min-w-0">
                    <h3 id="doc-preview-title" class="text-xs sm:text-base font-bold text-white truncate leading-tight">Preview Dokumen</h3>
                    <p id="doc-preview-filename" class="text-[10px] sm:text-[11px] text-white/75 truncate mt-0.5">-</p>
                </div>
            </div>

            <!-- Tombol Aksi Header -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <!-- Tombol Unduh / Buka Asli -->
                <a id="doc-preview-download" href="#" target="_blank" download class="inline-flex items-center gap-1.5 rounded-lg bg-white/15 hover:bg-white/25 px-2.5 sm:px-3 py-1.5 text-xs font-bold text-white transition backdrop-blur-xs" title="Unduh file">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path>
                    </svg>
                    <span class="hidden sm:inline">Unduh</span>
                </a>

                <!-- Tombol Tutup -->
                <button type="button" onclick="closeDocumentPreview()" class="flex h-8 w-8 items-center justify-center rounded-full text-white/80 transition hover:bg-white/20 hover:text-white cursor-pointer" aria-label="Tutup preview">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Body Konten Preview -->
        <div class="relative flex-1 overflow-auto min-h-[260px] sm:min-h-[350px] max-h-[calc(100dvh-70px)] sm:max-h-[calc(92vh-60px)] bg-gray-50 dark:bg-[#0f1c19] flex items-center justify-center">
            
            <!-- 1. Preview PDF (iframe) -->
            <iframe id="doc-preview-pdf" src="" class="hidden w-full h-[65dvh] sm:h-[72vh] border-0 bg-white dark:bg-[#0f1c19]" title="Preview PDF"></iframe>

            <!-- 2. Preview Gambar (img) -->
            <div id="doc-preview-image-container" class="hidden w-full h-full p-2 sm:p-4 flex items-center justify-center overflow-auto max-h-[65dvh] sm:max-h-[72vh]">
                <img id="doc-preview-img" src="" alt="Preview Gambar" class="max-h-[60dvh] sm:max-h-[68vh] max-w-full rounded-lg object-contain shadow-md transition-transform duration-200">
            </div>

            <!-- 3. Fallback Dokumen Lain (Word/Excel/dll) -->
            <div id="doc-preview-unsupported" class="hidden flex flex-col items-center justify-center py-10 sm:py-16 px-4 sm:px-6 text-center space-y-3 sm:space-y-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-emerald-100 dark:bg-[#1b3832] text-[#04733f] dark:text-emerald-300 flex items-center justify-center text-3xl sm:text-4xl shadow-inner">
                    📄
                </div>
                <div>
                    <h4 id="doc-unsupported-name" class="text-sm sm:text-base font-bold text-gray-800 dark:text-white">Dokumen Dokumen</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md">Format file ini (.docx/.doc) tidak dapat dipratinjau langsung di browser. Silakan unduh dokumen untuk membukanya.</p>
                </div>
                <a id="doc-unsupported-btn" href="#" download class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-[#04733f] hover:bg-[#035f35] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold rounded-xl text-xs shadow-md transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path>
                    </svg>
                    <span>Unduh Dokumen Sekarang</span>
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function openDocumentPreview(fileUrl, title = 'Preview Dokumen', fileName = '') {
        const modal = document.getElementById('modal-preview-dokumen');
        const titleEl = document.getElementById('doc-preview-title');
        const filenameEl = document.getElementById('doc-preview-filename');
        const downloadBtn = document.getElementById('doc-preview-download');
        const iconEl = document.getElementById('doc-preview-icon');

        const pdfFrame = document.getElementById('doc-preview-pdf');
        const imgContainer = document.getElementById('doc-preview-image-container');
        const imgEl = document.getElementById('doc-preview-img');
        const unsupportedContainer = document.getElementById('doc-preview-unsupported');
        const unsupportedName = document.getElementById('doc-unsupported-name');
        const unsupportedBtn = document.getElementById('doc-unsupported-btn');

        if (!modal || !fileUrl) return;

        // Ekstrak nama file jika belum disediakan
        const cleanFileName = fileName || fileUrl.split('/').pop().split('?')[0] || 'Dokumen';
        const fileExt = cleanFileName.split('.').pop().toLowerCase();

        // Set metadata header
        if (titleEl) titleEl.textContent = title;
        if (filenameEl) filenameEl.textContent = cleanFileName;
        if (downloadBtn) {
            downloadBtn.href = fileUrl;
            downloadBtn.setAttribute('download', cleanFileName);
        }

        // Reset display
        pdfFrame.classList.add('hidden');
        pdfFrame.src = '';
        imgContainer.classList.add('hidden');
        imgEl.src = '';
        unsupportedContainer.classList.add('hidden');

        // Deteksi Tipe File
        const imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        const isImage = imageExtensions.includes(fileExt);
        const isPdf = fileExt === 'pdf';

        if (isPdf) {
            if (iconEl) iconEl.textContent = '📑';
            pdfFrame.src = fileUrl;
            pdfFrame.classList.remove('hidden');
        } else if (isImage) {
            if (iconEl) iconEl.textContent = '🖼️';
            imgEl.src = fileUrl;
            imgContainer.classList.remove('hidden');
        } else {
            if (iconEl) iconEl.textContent = '📄';
            if (unsupportedName) unsupportedName.textContent = cleanFileName;
            if (unsupportedBtn) {
                unsupportedBtn.href = fileUrl;
                unsupportedBtn.setAttribute('download', cleanFileName);
            }
            unsupportedContainer.classList.remove('hidden');
        }

        modal.classList.replace('hidden', 'flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDocumentPreview() {
        const modal = document.getElementById('modal-preview-dokumen');
        if (!modal) return;

        const pdfFrame = document.getElementById('doc-preview-pdf');
        if (pdfFrame) pdfFrame.src = '';

        modal.classList.replace('flex', 'hidden');
        document.body.style.overflow = '';
    }

    function handleDocModalClick(event) {
        if (event.target.id === 'modal-preview-dokumen') {
            closeDocumentPreview();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('modal-preview-dokumen');
            if (modal && !modal.classList.contains('hidden')) {
                closeDocumentPreview();
            }
        }
    });
</script>
