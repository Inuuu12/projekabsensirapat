@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden" data-modal>
    <div class="modal-card">
        <div class="modal-head">
            <h2>{{ $title }}</h2>
            <button type="button" data-modal-close class="modal-close" aria-label="Tutup">@include('partials.icon', ['name' => 'x', 'class' => 'h-6 w-6'])</button>
        </div>
        <form class="modal-body">
            <label class="field-label">Nama Agenda
                <input class="field" placeholder="Masukkan nama agenda">
            </label>
            <div class="modal-grid" style="margin-top: 18px;">
                <label class="field-label">Tanggal
                    <input type="date" class="field">
                </label>
                <label class="field-label">Waktu
                    <input type="time" class="field">
                </label>
            </div>
            <label class="field-label" style="margin-top: 18px;">Asal Surat
                <input class="field" placeholder="Instansi/Bagian asal surat">
            </label>
            <label class="field-label" style="margin-top: 18px;">Ditugaskan Kepada
                <input class="field" placeholder="Masukkan nama pegawai">
            </label>
            <label class="field-label" style="margin-top: 18px;">Tempat
                <input class="field" placeholder="Lokasi kegiatan">
            </label>
            <label class="field-label" style="margin-top: 18px;">Keterangan
                <textarea class="textarea-field" placeholder="Detail tambahan agenda"></textarea>
            </label>
            <div class="modal-footer">
                <button type="button" data-modal-close class="btn-ghost">Batal</button>
                <button type="button" data-modal-close class="btn-save">@include('partials.icon', ['name' => 'save', 'class' => 'h-4 w-4']) Simpan</button>
            </div>
        </form>
    </div>
</div>
