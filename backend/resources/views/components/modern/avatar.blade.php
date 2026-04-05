@props(['name' => '', 'image' => null, 'size' => 'md', 'online' => false])

@php
$sizes = [
    'xs' => 'w-6 h-6 text-xs',
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-14 h-14 text-lg',
    'xl' => 'w-20 h-20 text-2xl',
];
$initials = strtoupper(substr($name, 0, 2));
@endphp

<div class="relative inline-flex">
    @if($image)
    <img src="{{ $image }}" alt="{{ $name }}" {{ $attributes->merge(['class' => 'rounded-full object-cover ' . $sizes[$size]]) }}>
    @else
    <div {{ $attributes->merge(['class' => 'rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold ' . $sizes[$size]]) }}>
        {{ $initials }}
    </div>
    @endif
    @if($online)
    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
    @endif
</div>
