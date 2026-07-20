@php
    $name = $name ?? 'circle';
    $class = $class ?? 'h-5 w-5';

    $paths = [
        'alert' => 'M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z',
        'chevron-down' => 'm6 9 6 6 6-6',
        'download' => 'M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m7-5 4 4 4-4m-4 4V3',
        'filter' => 'M22 3H2l8 9.46V19l4 2v-8.54L22 3Z',
        'logout' => 'M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m7 14 5-5-5-5m5 5H9',
        'plus' => 'M12 5v14m-7-7h14',
        'save' => 'M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Zm-7-4v-6m-4 6v-6h8v6',
        'search' => 'm21 21-4.34-4.34M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z',
        'trash' => 'M3 6h18m-2 0-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2',
        'users' => 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm13 10v-2a4 4 0 0 0-3-3.87m-4-11.26a4 4 0 0 1 0 7.75',
        'x' => 'M18 6 6 18M6 6l12 12',
    ];
@endphp

<svg class="{{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $paths[$name] ?? 'M12 12h.01' }}" />
</svg>
