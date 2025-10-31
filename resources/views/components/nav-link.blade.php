@props(['active'])

@php
$classes = ($active ?? false)
    ? 'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md bg-sky-700 text-white shadow-sm transition duration-150 ease-in-out'
    : 'w-full flex items-center px-4 py-2 text-sm font-medium rounded-md text-sky-800 hover:bg-sky-200 hover:text-sky-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
