<div>
    <x-page-header title="Cadastrar Equipamento">
    </x-page-header>
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-2 justify-center flex">
        <form wire:submit="save" class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 gap-6 flex flex-col">
                <div class="mt-6">
                    {{ $this->form }}
                </div>
                <p class="text-center my-2">Ao cadastrar um equipamento para empréstimo você reafirma estar ciente e em total concordância com nossos
                <button
                    type="button"
                    @click.prevent="$dispatch('open-slide-over', {title: 'Termos de Uso'});"
                    class="text-mobbi-blue hover:underline text-lg font-medium">
                        Termos de uso
                </button>.</p>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <x-forms.button type="submit" wire:loading.attr="disabled">
                    Salvar
                </x-forms.button>
                <a href="{{ url()->previous() }}">
                    <x-forms.button variant="outlined" class="mr-3" type="button">
                        Cancelar
                    </x-forms.button>
                </a>
            </div>
        </form>
    </main>

    <x-slide-over>
        <div class="prose prose-indigo lg:prose-lg text-gray-700 mx-auto">
            <x-terms.content />
        </div>
    </x-slide-over>
</div>
