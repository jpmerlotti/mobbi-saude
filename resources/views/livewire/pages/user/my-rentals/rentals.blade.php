<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Gestão de Aluguéis</h2>
    </div>

    <div class="flex space-x-1 rounded-xl bg-gray-200 p-1 w-fit">
        <button wire:click="setTab('received')" class="w-full rounded-lg py-2.5 px-6 text-sm font-medium leading-5 transition {{ $tab === 'received' ? 'bg-white text-mobbi-blue shadow' : 'text-gray-700 hover:bg-white/[0.12]' }}">
            Solicitações Recebidas
        </button>
        <button wire:click="setTab('sent')" class="w-full rounded-lg py-2.5 px-6 text-sm font-medium leading-5 transition {{ $tab === 'sent' ? 'bg-white text-mobbi-blue shadow' : 'text-gray-700 hover:bg-white/[0.12]' }}">
            Minhas Solicitações
        </button>
    </div>

    @if($tab === 'received')
        <div class="space-y-4">
            @forelse($this->receivedRentals as $rental)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center" wire:key="rec-{{ $rental->id }}">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-lg text-gray-900">{{ $rental->equipment->name }}</span>
                            <x-rental-status-badge :status="$rental->status" />
                        </div>
                        <p class="text-gray-500 text-sm">Solicitante: {{ $rental->borrower->name }}</p>
                    </div>

                    <div class="mt-4 md:mt-0 flex gap-3">
                        @if($rental->status === \App\Enums\RentalStatus::PENDING)
                            <button
                                wire:click="mountAction('approve', { record: {{ $rental->id }} })"
                                class="flex items-center gap-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                                <x-heroicon-o-check-circle class="w-4 h-4"/> Aprovar
                            </button>

                            <button
                                wire:click="mountAction('reject', { record: {{ $rental->id }} })"
                                class="flex items-center gap-1 px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium rounded-lg transition">
                                <x-heroicon-o-x-circle class="w-4 h-4"/> Recusar
                            </button>
                        @else
                           <span class="text-sm text-gray-400 italic">Sem ações disponíveis</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">Nenhuma solicitação.</div>
            @endforelse
             <div class="mt-4">{{ $this->receivedRentals->links() }}</div>
        </div>
    @endif

    @if($tab === 'sent')
        <div class="space-y-4">
            @forelse($this->sentRentals as $rental)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center" wire:key="sent-{{ $rental->id }}">
                    <div>
                         <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-lg text-gray-900">{{ $rental->equipment->name }}</span>
                            <x-rental-status-badge :status="$rental->status" />
                        </div>
                        <p class="text-gray-500 text-sm">Dono: {{ $rental->equipment->owner->name ?? '-' }}</p>
                    </div>

                    <div class="mt-4 md:mt-0">
                         @if($rental->status === \App\Enums\RentalStatus::PENDING)
                            <button
                                wire:click="mountAction('cancel', { record: {{ $rental->id }} })"
                                class="flex items-center gap-1 px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-300 text-sm font-medium rounded-lg transition">
                                <x-heroicon-o-trash class="w-4 h-4"/> Cancelar
                            </button>
                        @else
                           <span class="text-sm text-gray-400 italic">Finalizado</span>
                        @endif
                    </div>
                </div>
            @empty
                 <div class="text-center py-12 text-gray-500">Nada aqui.</div>
            @endforelse
            <div class="mt-4">{{ $this->sentRentals->links() }}</div>
        </div>
    @endif

    <x-filament-actions::modals />
</div>
