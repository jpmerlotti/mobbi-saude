@use(\App\Models\Equipment)

<div>
    <x-page-header title="Meus Equipamentos" backUrl>
        @can('create', Equipment::class)
            <a href="{{ route('my-equipments.create') }}">
                <x-forms.button class="flex gap-1">
                    Cadastrar <span class="hidden md:block">Equipamento</span>
                </x-forms.button>

            </a>
        @endcan
    </x-page-header>

    {{-- Corpo da Página --}}
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-2">
        @if( auth()->user()->hasCompletedProfile() )
            <div class="flex flex-row items-center gap-4 justify-end space-y-2">
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

            {{-- Listagem dos Equipamentos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 ">
                @if($this->displayMode === 'grid')
                    @forelse ($this->equipments as $equipment)
                        <div class="group block bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            <img class="h-48 w-full object-cover"
                                src="{{ $equipment->thumbnail }}"
                                alt="Foto de {{ $equipment->name }}">
                            <div class="p-4 flex-grow">
                                <p class="text-sm font-semibold text-mobbi-pink">{{ $equipment->equipmentType->name }}</p>
                                <h3 class="mt-1 text-lg font-bold text-gray-900 truncate">{{ $equipment->name }}</h3>
                            </div>
                            <div class="p-2 bg-gray-50 border-t flex justify-end space-x-2">
                                <a href="{{ route('my-equipments.edit', ['equipment' => $equipment]) }}" wire:navigate>
                                    <x-forms.button variant="ghost" class="text-gray-400 hover:text-mobbi-blue transition-colors">
                                        <x-heroicon-o-pencil-square class="h-5 w-5"/>
                                    </x-forms.button>
                                </a>
                                <x-forms.button variant="ghost" wire:click="delete({{ $equipment->id }})" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <x-heroicon-o-trash class="h-5 w-5"/>
                                </x-forms.button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">Você ainda não cadastrou nenhum equipamento.</p>
                            <a href="{{ route('my-equipments.create') }}">
                                <x-forms.button class="mt-4">
                                    Cadastre seu primeiro equipamento
                                </x-forms.button>
                            </a>
                        </div>
                    @endforelse
                @else
                    <div class="flex flex-col col-span-full space-y-6">
                        @forelse ($this->equipments as $equipment)
                            <div class="min-w-full group flex bg-white rounded-lg shadow-md overflow-hidden transition-shadow duration-300 hover:shadow-xl justify-between">
                                <div class="flex flex-col md:flex-row">
                                    <img class="h-24 w-24 flex-shrink-0 object-cover"
                                        src="{{ $equipment->thumbnail }}"
                                        alt="Foto de {{ $equipment->name }}">
                                    <div class="p-4 flex flex-col justify-center">
                                        <p class="text-sm font-semibold text-mobbi-pink">{{ $equipment->equipmentType->name }}</p>
                                        <h3 class="mt-1 text-lg font-bold text-gray-900 group-hover:text-mobbi-blue transition-colors">{{ $equipment->name }}</h3>
                                    </div>
                                </div>
                                <div class="p-2 bg-gray-50 flex flex-col md:flex-row justify-between md:justify-end space-x-2">
                                    <x-forms.button variant="ghost" wire:click="edit({{ $equipment->public_id }})" class="text-gray-400 hover:text-mobbi-blue transition-colors">
                                        <x-heroicon-o-pencil-square class="h-5 w-5"/>
                                    </x-forms.button>
                                    <x-forms.button variant="ghost" wire:click="delete({{ $equipment->public_id }})" wire:confirm="Tem certeza que deseja remover este equipamento?" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <x-heroicon-o-trash class="h-5 w-5"/>
                                    </x-forms.button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">Você ainda não cadastrou nenhum equipamento.</p>
                                <a href="{{ route('my-equipments.create') }}">
                                    <x-forms.button class="mt-4">
                                        Cadastre seu primeiro equipamento
                                    </x-forms.button>
                                </a>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        @else
            <div class="flex flex-col justify-center items-center">
                <p>
                    Seu perfil ainda não está completo.
                </p>
                <p>
                    Para poder cadastrar equipamentos para empréstimo, primeiro é necessário preencher alguns dados adicionais em
                    <a class="text-lg text-mobbi-blue hover:underline font-medium"
                        href="{{route('profile')}}">Meu Perfil</a>
                </p>
            </div>
        @endif
    </main>


    {{-- MODAL DE CADASTRO/EDIÇÃO --}}
    <div x-data="{ show: @entangle('showModal') }"
        x-show="show"
        x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-1 overflow-y-auto"
        style="display: none;">

        <div class="flex items-center justify-center min-h-screen">
            {{-- Overlay --}}
            <div x-show="show"
                x-transition.opacity
                class="fixed inset-0 bg-black/75"></div>

            {{-- Conteúdo do Modal --}}
            <div x-show="show"
                x-transition @click.away="show = false"
                class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-2xl sm:w-full z-1">
                <div class="px-7 py-9 flex flex-col items-center gap-">
                    <h3 class="text-2xl text-mobbi-pink flex gap-2 justify-center">
                        <x-heroicon-o-exclamation-circle class="h-8 w-8" />
                        Remover equipamento
                    </h3>
                    <p class="text-center">Essa ação não pode ser desfeita.</p>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row">
                        <x-forms.button type="button" variant="outlined" class="mr-3" @click="show = false">
                            Cancelar
                        </x-forms.button>

                        <x-forms.button wire:loading.attr="disabled" wire:click="destroy()" class="bg-mobbi-pink hover:bg-mobbi-pink-700">
                            Deletar
                        </x-forms.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

