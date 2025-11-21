@props(['status'])

@php
    $colors = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'approved' => 'bg-green-100 text-green-800 border-green-200',
        'rejected' => 'bg-red-100 text-red-800 border-red-200',
        'canceled' => 'bg-gray-100 text-gray-600 border-gray-200',
    ];

    $label = $status instanceof \App\Enums\RentalStatus ? $status->getLabel() : $status;
    $value = $status instanceof \App\Enums\RentalStatus ? $status->value : $status;

    $classes = $colors[$value] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $classes }}">
    {{ $label }}
</span>
