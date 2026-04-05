@props(['padding' => 'p-6', 'hover' => false, 'class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-card ' . $padding . ' ' . ($hover ? 'hover:shadow-soft transition-smooth cursor-pointer' : '') . ' ' . $class]) }}>
    {{ $slot }}
</div>
