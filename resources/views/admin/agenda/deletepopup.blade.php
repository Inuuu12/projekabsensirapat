<!-- MODAL KONFIRMASI HAPUS CUSTOM -->
<div id="modal-konfirmasi-hapus" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4 transition-all duration-200">
    <div class="bg-white dark:bg-[#152420] dark:border dark:border-[#284c43] rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-6 text-center transform scale-95 transition-all">
        
        <!-- Icon Peringatan Merah Muda -->
        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 dark:bg-red-950/60 flex items-center justify-center">
            <svg class="w-8 h-8 text-[#B91C1C] dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>

        <!-- Judul & Deskripsi -->
        <div class="space-y-2">
            <h3 id="delete-modal-title" class="text-xl font-black text-[#062c26] dark:text-white">Hapus Agenda?</h3>
            <p id="delete-modal-desc" class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 font-medium leading-relaxed">
                Apakah Anda yakin ingin menghapus agenda ini?
            </p>
        </div>

        <!-- Form Action & Tombol -->
        <form id="form-konfirmasi-hapus" method="POST" action="" class="pt-3 border-t border-gray-100 dark:border-[#233a34] grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3">
            @csrf
            @method('DELETE')
            
            <!-- Tombol Batal -->
            <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto h-10 px-4 text-xs font-bold text-[#062c26] dark:text-gray-200 bg-white dark:bg-[#0f1c19] border border-gray-300 dark:border-[#284c43] rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">
                Batal
            </button>
            
            <!-- Tombol Hapus -->
            <button type="submit" class="w-full sm:w-auto h-10 px-4 text-xs font-bold text-white bg-[#B91C1C] hover:bg-[#991B1B] dark:bg-red-700 dark:hover:bg-red-800 rounded-xl flex items-center justify-center gap-2 shadow-xs transition cursor-pointer">
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(actionUrl, title = 'Hapus Agenda?', desc = 'Apakah Anda yakin ingin menghapus agenda ini?') {
        const modal = document.getElementById('modal-konfirmasi-hapus');
        const form = document.getElementById('form-konfirmasi-hapus');
        const titleEl = document.getElementById('delete-modal-title');
        const descEl = document.getElementById('delete-modal-desc');

        if (form) form.action = actionUrl;
        if (titleEl) titleEl.innerText = title;
        if (descEl) descEl.innerText = desc;

        if (modal) {
            modal.classList.replace('hidden', 'flex');
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('modal-konfirmasi-hapus');
        if (modal) {
            modal.classList.replace('flex', 'hidden');
        }
    }
</script>
@endpush