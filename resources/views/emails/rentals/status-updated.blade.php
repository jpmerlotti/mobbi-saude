@php
    $isApproved = $rental->status === \App\Enums\RentalStatus::APPROVED;
    $btnColor = $isApproved ? 'bg-green' : 'bg-gray'; // Usando nossas classes CSS do layout
    $title = $isApproved ? 'Sua solicitação foi Aprovada! 🎉' : 'Solicitação Recusada 😕';

    // Ajuste da cor da borda do painel dependendo do status
    $borderColor = $isApproved ? '#10b981' : '#ef4444';
@endphp

<x-layouts.email>
    <h2 style="margin-top: 0; color: #111827;">Olá, {{ $rental->borrower->name }}!</h2>

    <p class="text-gray">
        Temos uma atualização sobre o aluguel do item <strong>{{ $rental->equipment->name }}</strong>.
    </p>

    <div class="panel" style="border-left-color: {{ $borderColor }};">
        <h3 style="margin-top: 0;">{{ $title }}</h3>

        <p style="margin: 5px 0;"><strong>Status Atual:</strong> {{ $rental->status->getLabel() }}</p>

        @if($rental->status === \App\Enums\RentalStatus::REJECTED && !empty($rental->rejection_reason))
            <p style="margin: 15px 0 5px 0; color: #ef4444;"><strong>Motivo:</strong> {{ $rental->rejection_reason }}</p>
        @endif
    </div>

    @if($isApproved)
        <p class="text-gray">Combine a retirada do equipamento ou verifique os próximos passos no painel.</p>
    @else
        <p class="text-gray">Você pode buscar outros equipamentos disponíveis em nossa plataforma.</p>
    @endif

    <div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
        <a href="{{ route('my-rentals.index') }}" class="button {{ $btnColor }}">
            Ver Detalhes
        </a>
    </div>

    <p class="text-gray" style="font-size: 14px;">
        Atenciosamente,<br>
        Equipe {{ config('app.name') }}
    </p>
</x-layouts.email>
