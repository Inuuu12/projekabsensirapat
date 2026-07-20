@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden" data-modal>
    <div class="modal-card">
        <div class="modal-head">
            <h2>{{ $title }}</h2>
            <button type="button" data-modal-close class="modal-close" aria-label="Tutup">@include('partials.icon', ['name' => 'x', 'class' => 'h-6 w-6'])</button>
        </div>
        <form class="modal-body">
            <label class="field-label">Nama Ruangan
                <input class="field" value="Ruang Rapat Paripurna">
            </label>
            <div class="modal-grid" style="margin-top: 18px;">
                <label class="field-label">Kapasitas
                    <input class="field" value="50">
                </label>
                <label class="field-label">Status
                    <select class="select-field">
                        <option>Tersedia</option>
                        <option>Digunakan</option>
                        <option>Perawatan</option>
                    </select>
                </label>
            </div>
            <label class="field-label" style="margin-top: 18px;">Foto Ruangan
                <div style="display:flex;min-height:96px;align-items:center;justify-content:center;border:2px dashed #b8c5c1;border-radius:8px;text-align:center;color:#243432;">
                    <div>
                        <div style="font-weight:800;">Click to update or drag and drop</div>
                        <div style="margin-top:4px;font-size:12px;color:#6c7774;">JPG, PNG up to 5MB</div>
                    </div>
                </div>
            </label>
            <div class="modal-footer">
                <button type="button" data-modal-close class="btn-ghost">Batal</button>
                <button type="button" data-modal-close class="btn-save">@include('partials.icon', ['name' => 'save', 'class' => 'h-4 w-4']) Simpan</button>
            </div>
        </form>
    </div>
</div>
