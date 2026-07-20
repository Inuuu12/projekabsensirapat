@props(['search' => 'Cari...', 'button' => 'Tambah', 'modal' => null, 'compact' => false])

<div class="toolbar">
    <div class="toolbar-left">
        @if (!$compact)
            <button class="select-rows">10 Baris</button>
        @endif
        <div class="searchbox wide">
            @include('partials.icon', ['name' => 'search', 'class' => 'h-5 w-5'])
            <input type="search" placeholder="{{ $search }}">
        </div>
    </div>
    <div class="toolbar-actions">
        <button class="btn-outline">@include('partials.icon', ['name' => 'filter', 'class' => 'h-4 w-4']) Filter</button>
        <button class="btn-outline">@include('partials.icon', ['name' => 'download', 'class' => 'h-4 w-4']) Export</button>
        <button type="button" data-modal-open="{{ $modal }}" class="btn-primary">@include('partials.icon', ['name' => 'plus', 'class' => 'h-6 w-6']) {{ $button }}</button>
    </div>
</div>
