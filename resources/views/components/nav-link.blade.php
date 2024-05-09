@props(['active','navigate' => true])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center space-x-2 text-sm text-yellow-500 hover:text-yellow-900'
            : 'inline-flex items-center space-x-2 text-sm text-gray-500 hover:text-yellow-900';
@endphp

<a {{ $navigate ? 'wire:navigate' : ''}} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
