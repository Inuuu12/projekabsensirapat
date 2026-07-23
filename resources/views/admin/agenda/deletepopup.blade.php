<!-- MODAL KONFIRMASI HAPUS CUSTOM -->
<div id="modal-konfirmasi-hapus" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs hidden items-center justify-center p-4 transition-all duration-200">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-6 text-center transform scale-95 transition-all">
        
        <!-- Icon Peringatan Merah Muda -->
        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-[#B91C1C]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>

        <!-- Judul & Deskripsi -->
        <div class="space-y-2">
            <h3 id="delete-modal-title" class="text-xl font-black text-[#062c26]">Hapus Agenda?</h3>
            <p id="delete-modal-desc" class="text-xs sm:text-sm text-gray-500 font-medium leading-relaxed">
                Apakah Anda yakin ingin menghapus agenda ini?
            </p>
        </div>

        <!-- Form Action & Tombol -->
        <form id="form-konfirmasi-hapus" method="POST" action="" class="pt-2 border-t border-gray-100 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            
            <!-- Tombol Batal -->
            <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-xs font-bold text-[#062c26] bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                Batal
            </button>
            
            <!-- Tombol Hapus -->
            <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-[#B91C1C] hover:bg-[#991B1B] rounded-xl flex items-center gap-2 shadow-xs transition cursor-pointer">
                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="w-3.5 h-3.5 object-contain brightness-0 invert">
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