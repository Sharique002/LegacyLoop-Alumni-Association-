@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'href' => null, 'icon' => null])

@php
$variants = [
    'primary' => 'bg-primary-500 hover:bg-primary-600 text-white shadow-sm',
    'secondary' => 'bg-secondary-500 hover:bg-secondary-600 text-white',
    'outline' => 'border-2 border-primary-500 text-primary-500 hover:bg-primary-50',
    'ghost' => 'text-muted hover:text-dark hover:bg-gray-100',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white',
];
$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];
$classes = 'inline-flex items-center justify-center font-medium rounded-xl transition-smooth focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>@endif
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>@endif
    {{ $slot }}
</button>
@endif
