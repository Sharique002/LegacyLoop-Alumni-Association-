@props(['color' => 'primary', 'size' => 'sm'])

@php
$colors = [
    'primary' => 'bg-primary-100 text-primary-700',
    'secondary' => 'bg-secondary-100 text-secondary-700',
    'success' => 'bg-green-100 text-green-700',
    'warning' => 'bg-yellow-100 text-yellow-700',
    'danger' => 'bg-red-100 text-red-700',
    'gray' => 'bg-gray-100 text-gray-700',
];
$sizes = [
    'xs' => 'px-2 py-0.5 text-xs',
    'sm' => 'px-2.5 py-1 text-xs',
    'md' => 'px-3 py-1.5 text-sm',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium rounded-full ' . $colors[$color] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
</span>
