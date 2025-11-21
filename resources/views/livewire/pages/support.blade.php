<div class="">
    <x-page-header title="Suporte"  backUrl></x-page-header>

    <main class="bg-white max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex justify-center">
        <form wire:submit="send" class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl z-50 transform sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 gap-6 flex flex-col">
                <div class="mt-6">
                    {{ $this->form }}
                </div>


                <div class="flex flex-col md:flex-row justify-end gap-6">
                    <x-forms.button variant="primary" wire:loading.attr="disabled" wire:submit.prevent>Enviar</x-forms.button>
                </div>
            </div>
        </form>
    </main>
</div>
