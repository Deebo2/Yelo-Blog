@props(['author', 'size'])
@php
    $imageSize = match ($size ?? null) {
        'xs' => 'w-7 h-7',
        'sm' => 'w-9 h-9',
        'md' => 'w-10 h-10',
        'lg' => 'w-13 h-13',
        default => 'w-7 h-7',
    };
    $textSize = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
        default => 'text-base',
    };
@endphp
<img class="mr-3 rounded-full {{ $imageSize }}" src="{{ $author->profile_photo_url }}" alt="{{ $author->name }}">
<span class="mr-1 {{ $textSize }}">{{ $author->name }}</span>
