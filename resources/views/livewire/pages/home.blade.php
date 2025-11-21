<div>
    {{-- Seção de Título e Filtros --}}
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-center text-mobbi-blue">Encontre o que você precisa</h1>
            <p class="mt-2 text-lg text-center text-gray-600">Explore os equipamentos disponíveis em nossa comunidade.</p>

            {{-- Controles de Filtro e Exibição --}}
            <div class="flex flex-col md:flex-row min-w-full mt-8 gap-4 md:items-center md:justify-center">
                <div class="max-w-[75%] items-center">
                    {{ $this->form }}
                </div>
                {{-- Botões de Modo de Exibição --}}
                <div class="flex flex-col md:justify-end space-y-2 max-w-[25%]">
                    <span class="text-sm text-gray-500">Exibir como:</span>
                    <div class="flex items-center space-x-2">
                        <button wire:click="changeDisplayMode('grid')" class="{{ $displayMode === 'grid' ? 'bg-mobbi-blue text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }} p-2 rounded-md shadow-sm transition">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                        <button wire:click="changeDisplayMode('list')" class="{{ $displayMode === 'list' ? 'bg-mobbi-blue text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }} p-2 rounded-md shadow-sm transition">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Seção de Listagem dos Equipamentos --}}
    <div flex flex-col justify-center class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        {{-- Modo GRID --}}
        @if ($this->displayMode === 'grid')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($this->equipments as $equipment)
                    <a href="{{ route('show-equipment', ['equipment' => $equipment]) }}" class="group block bg-white rounded-lg shadow-md overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                        <div class="relative">
                            <img class="h-48 w-full object-cover"
                                 src="{{ $equipment->thumbnail }}"
                                 alt="Foto de {{ $equipment->name }}">
                        </div>
                        <div class="p-4">
                            <p class="text-sm font-semibold text-mobbi-pink">{{ $equipment->equipmentType->name }}</p>
                            <h3 class="mt-1 text-lg font-bold text-gray-900 truncate group-hover:text-mobbi-blue transition-colors">{{ $equipment->name }}</h3>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500">Nenhum equipamento encontrado com os filtros aplicados.</p>
                @endforelse
            </div>
        {{-- Modo LISTA --}}
        @else
            <div class="space-y-4">
                @forelse ($this->equipments as $equipment)
                    <a href="{{ route('show-equipment', ['equipment' => $equipment]) }}" class="group flex bg-white rounded-lg shadow-md overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                        <img class="h-24 w-24 flex-shrink-0 object-cover"
                             src="{{ $equipment->thumbnail }}"
                             alt="Foto de {{ $equipment->name }}">
                        <div class="p-4 flex flex-col justify-center">
                            <p class="text-sm font-semibold text-mobbi-pink">{{ $equipment->equipmentType->name }}</p>
                            <h3 class="mt-1 text-lg font-bold text-gray-900 group-hover:text-mobbi-blue transition-colors">{{ $equipment->name }}</h3>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-gray-500">Nenhum equipamento encontrado com os filtros aplicados.</p>
                @endforelse
            </div>
        @endif

        {{-- Links de Paginação --}}
        <div class="mt-10">
            {{ $this->equipments->links() }}
        </div>
    </div>
</div>