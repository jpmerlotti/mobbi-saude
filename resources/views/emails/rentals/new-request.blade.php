<x-layouts.email>
    <h2 style="margin-top: 0; color: #111827;">Olá, {{ $rental->equipment->owner->name }}! 👋</h2>

    <p class="text-gray">
        Você recebeu uma nova solicitação de aluguel para o equipamento <strong>{{ $rental->equipment->name }}</strong>.
    </p>

    <div class="panel">
        <p style="margin: 5px 0;"><strong>Solicitante:</strong> {{ $rental->borrower->name }}</p>
        <p style="margin: 5px 0;"><strong>Data do Pedido:</strong> {{ $rental->created_at->format('d/m/Y às H:i') }}</p>

        @if($rental->start_date && $rental->end_date)
            <p style="margin: 5px 0;"><strong>Período:</strong> {{ $rental->start_date->format('d/m/Y') }} até {{ $rental->end_date->format('d/m/Y') }}</p>
        @endif
    </div>

    <p class="text-gray">Acesse o painel para aprovar ou recusar esta solicitação.</p>

    <div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
        <a href="{{ route('my-rentals.index') }}" class="button bg-blue">
            Gerenciar Solicitação
        </a>
    </div>

    <p class="text-gray" style="font-size: 14px;">
        Obrigado,<br>
        Equipe {{ config('app.name') }}
    </p>
</x-layouts.email>
