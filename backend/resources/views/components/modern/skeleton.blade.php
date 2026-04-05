@props(['type' => 'card'])

@if($type === 'card')
<div class="bg-white rounded-xl shadow-card p-6 animate-pulse">
    <div class="flex items-center space-x-4 mb-4">
        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
        <div class="flex-1">
            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
        </div>
    </div>
    <div class="space-y-2">
        <div class="h-3 bg-gray-200 rounded"></div>
        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
    </div>
</div>
@elseif($type === 'list')
<div class="space-y-3">
    @for($i = 0; $i < 5; $i++)
    <div class="flex items-center space-x-4 animate-pulse">
        <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
        <div class="flex-1">
            <div class="h-4 bg-gray-200 rounded w-1/2 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-1/3"></div>
        </div>
    </div>
    @endfor
</div>
@elseif($type === 'text')
<div class="space-y-2 animate-pulse">
    <div class="h-4 bg-gray-200 rounded w-full"></div>
    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
    <div class="h-4 bg-gray-200 rounded w-4/6"></div>
</div>
@endif
