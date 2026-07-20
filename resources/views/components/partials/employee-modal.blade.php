@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden" data-modal>
    <div class="modal-card">
        <div class="modal-head">
            <h2>{{ $title }}</h2>
            <button type="button" data-modal-close class="modal-close" aria-label="Tutup">@include('partials.icon', ['name' => 'x', 'class' => 'h-6 w-6'])</button>
        </div>
        <form class="modal-body">
            <div class="upload-avatar">
                <div class="upload-circle">
                    @include('partials.icon', ['name' => 'users', 'class' => 'h-9 w-9'])
                </div>
                <p>Unggah Foto Profil</p>
            </div>

            <div class="modal-grid">
                <label class="field-label">Nama Lengkap <span style="color:#c9141d">*</span>
                    <input class="field" placeholder="Masukkan nama lengkap">
                </label>
                <label class="field-label">NIP <span style="color:#c9141d">*</span>
                    <input class="field" placeholder="Masukkan Nomor Induk Pegawai">
                </label>
                <label class="field-label">Jabatan
                    <input class="field" placeholder="Contoh: Analis Kebijakan">
                </label>
                <label class="field-label">Bidang
                    <input class="field" placeholder="Contoh: Sekretariat">
                </label>
                <label class="field-label">Email
                    <input class="field" placeholder="Masukkan Email">
                </label>
            </div>

            <div class="modal-footer">
                <button type="button" data-modal-close class="btn-ghost">Batal</button>
                <button type="button" data-modal-close class="btn-save">@include('partials.icon', ['name' => 'save', 'class' => 'h-4 w-4']) Simpan</button>
            </div>
        </form>
    </div>
</div>
