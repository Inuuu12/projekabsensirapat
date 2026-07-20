@props(['name', 'class' => 'h-5 w-5'])

@php($stroke = 'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"')

@switch($name)
    @case('dashboard')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z"/></svg>
        @break
    @case('agenda')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
        @break
    @case('rekap')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M4 19V5"/><path d="M8 19v-8"/><path d="M12 19V8"/><path d="M16 19v-5"/><path d="M20 19V4"/></svg>
        @break
    @case('users')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        @break
    @case('masukan')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3C6.9 3 3 6.28 3 10.55c0 2.57 1.43 4.8 3.72 6.16L6 21l4.55-2.98c.47.06.95.09 1.45.09 5.1 0 9-3.28 9-7.56S17.1 3 12 3Zm-1 4h2v6h-2V7Zm0 8h2v2h-2v-2Z"/></svg>
        @break
    @case('chevron-down')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="m6 9 6 6 6-6"/></svg>
        @break
    @case('logout')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
        @break
    @case('search')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        @break
    @case('plus')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M12 5v14M5 12h14"/></svg>
        @break
    @case('edit')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
        @break
    @case('trash')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6 18 20H6L5 6"/><path d="M10 11v5M14 11v5"/></svg>
        @break
    @case('filter')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M4 6h16M7 12h10M10 18h4"/></svg>
        @break
    @case('download')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>
        @break
    @case('save')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
        @break
    @case('x')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M18 6 6 18M6 6l12 12"/></svg>
        @break
    @case('eye')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('alert')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 21h22L12 2Zm-1 7h2v6h-2V9Zm0 8h2v2h-2v-2Z"/></svg>
        @break
    @default
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" {!! $stroke !!}><circle cx="12" cy="12" r="9"/></svg>
@endswitch
