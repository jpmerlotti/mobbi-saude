<div>
    <x-page-header title="Meu perfil" />
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{-- Layout Principal: Coluna de Navegação (futuro) + Conteúdo --}}
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                {{-- Card do Usuário (Acolhedor) --}}
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                    <img class="h-24 w-24 rounded-full object-cover" src="{{ auth()->user()->avatar }}" alt="Avatar">
                    <h2 class="mt-4 text-xl font-bold text-gray-800">Olá, {{ strtok(auth()->user()->name, " ") }}!</h2>
                    <p class="text-sm text-gray-500">Mantenha seus dados seguros e atualizados.</p>
                </div>
            </aside>

            {{-- Conteúdo Principal: Formulário --}}
            <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                {{-- Notificação de Sucesso --}}
                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                {{-- Formulário Renderizado pelo Filament --}}
                <form wire:submit="save" class="flex flex-col items-end">
                    {{ $this->form }}

                    <x-terms.terms-slide-over />

                    <div class="mt-8 flex justify-end">
                        <x-forms.button type="submit">
                            Salvar Alterações
                        </x-forms.button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
