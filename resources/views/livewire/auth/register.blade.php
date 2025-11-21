<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md md:max-w-lg p-8 bg-white rounded-lg shadow-lg flex flex-col border-mobbi-blue border-2 ring-mobbi-blue">
        <h1 class="text-3xl font-bold text-center text-mobbi-pink mb-6">Crie sua conta</h1>

        <form wire:submit="register" class="space-y-6 flex flex-col items-center">

            {{ $this->form }}

            <x-forms.button variant="primary" class="w-full md:w-auto">
                Registrar
            </x-forms.button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Já tem uma conta? <a href="{{ route('auth.login') }}" class="font-medium text-mobbi-pink hover:underline" wire:navigate>Faça login</a></p>
    </div>
</div>
