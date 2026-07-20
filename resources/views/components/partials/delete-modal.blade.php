@props(['id', 'title', 'message'])

<div id="{{ $id }}" class="modal hidden" data-modal>
    <div class="modal-card small">
        <div class="delete-body">
            <div class="alert-circle">
                @include('partials.icon', ['name' => 'alert', 'class' => 'h-8 w-8'])
            </div>
            <h2 class="delete-title">{{ $title }}</h2>
            <p class="delete-message">{{ $message }}</p>
        </div>
        <div class="delete-footer">
            <button type="button" data-modal-close class="btn-cancel">Batal</button>
            <button type="button" data-modal-close class="btn-danger">@include('partials.icon', ['name' => 'trash', 'class' => 'h-4 w-4']) Hapus</button>
        </div>
    </div>
</div>
