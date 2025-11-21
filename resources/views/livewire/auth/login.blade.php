<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md md:max-w-lg p-8 bg-white rounded-lg shadow-lg border-2 border-mobbi-blue ring-mobbi-blue">
        <h1 class="text-3xl font-bold text-center text-mobbi-pink mb-6">Acesse sua conta</h1>

        <form wire:submit="authenticate" class="space-y-6 items-center flex flex-col w-full">

            {{ $this->form }}

            <x-forms.button variant="primary" class="w-full md:w-auto">
                Entrar
            </x-forms.button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Não tem uma conta? <a href="{{ route('auth.register') }}" class="font-medium text-mobbi-pink hover:underline" wire:navigate>Registre-se</a></p>
    </div>
</div>
