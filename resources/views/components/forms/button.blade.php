@props(['type' => 'submit', 'variant' => 'primary'])
@php
    // Define as classes base que são comuns a todas as variantes
    $baseClasses = 'inline-flex items-center justify-center px-4 py-2 border rounded-md font-semibold text-sm tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

    // Define as classes específicas para cada variante
    $variantClasses = [
        'primary' => 'bg-mobbi-blue-600 border-transparent text-white hover:bg-mobbi-blue-700 focus:ring-mobbi-blue-500',
        'outlined' => 'border-mobbi-blue-600 text-mobbi-blue-600 hover:bg-mobbi-blue-600 hover:text-white focus:ring-mobbi-blue-500',
        'ghost' => 'border-transparent text-gray-700 hover:bg-gray-200 focus:ring-mobbi-blue-500',
    ];

    // Concatena as classes base com as classes da variante selecionada
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>