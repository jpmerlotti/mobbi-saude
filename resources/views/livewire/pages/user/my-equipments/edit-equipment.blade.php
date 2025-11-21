<div class="">
    <x-page-header title="Meus Equipamentos" backUrl>
        <x-forms.button wire:click="openModal" class="flex gap-1" class="bg-mobbi-pink hover:bg-mobbi-pink-700">
            Deletar <span class="hidden md:block">Equipamento</span>
        </x-forms.button>
    </x-page-header>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-2 flex justify-center">
            <form wire:submit="save" class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 gap-6 flex flex-col">
                    <div class="mt-6">
                        {{ $this->form }}
                    </div>

                    <div class="flex flex-col md:flex-row justify-start gap-6">
                        <x-forms.button variant="primary" wire:loading.attr="disabled">
                            Salvar
                        </x-forms.button>
                        <a href="{{ route('my-equipments.index') }}">
                            <x-forms.button variant="outlined">Cancelar</x-forms.button>
                        </a>
                    </div>
                </div>
            </form>
    </main>

    <div x-data="{ show: @entangle('showModal') }"
        x-show="show"
        x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">

        <div class="flex items-center justify-center min-h-screen">
            {{-- Overlay --}}
            <div x-show="show"
                x-transition.opacity
                class="fixed inset-0 bg-black/75 z-40"></div>

            {{-- Conteúdo do Modal --}}
            <div x-show="show"
                x-transition @click.away="show = false"
                class="inline-block relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-2xl sm:w-full z-50">
                    <div class="px-7 py-9 flex flex-col items-center gap-6">
                        <div>
                            <h3 class="text-2xl text-mobbi-pink flex gap-2 justify-center">
                                <x-heroicon-o-exclamation-circle class="h-8 w-8" />
                                Remover equipamento
                            </h3>
                            <p class="text-center">Essa ação não pode ser desfeita.</p>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row">
                            <x-forms.button type="button" variant="outlined" class="mr-3" @click="show = false">
                                Cancelar
                            </x-forms.button>

                            <x-forms.button wire:click="delete()" wire:loading.attr="disabled" class="bg-mobbi-pink hover:bg-mobbi-pink-700">
                                Deletar
                            </x-forms.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
