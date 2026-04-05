@props(['label' => null, 'name', 'type' => 'text', 'required' => false, 'error' => null])

<div>
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-dark mb-2">
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    @endif
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-white border rounded-xl text-sm placeholder-muted transition-smooth focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent ' . ($error ? 'border-red-300' : 'border-gray-200')]) }}
    >
    @if($error)
    <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @endif
</div>
