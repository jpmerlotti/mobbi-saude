<div class="flex items-center justify-center min-h-screen bg-mobbi-blue">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-mobbi-pink mb-6">Acesse sua conta</h1>

        <form wire:submit.prevent="authenticate" class="space-y-6">
            
            {{ $this->form }}

            <x-forms.button type="submit" variant="outlined">
                Entrar
            </x-forms.button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Não tem uma conta? <a href="{{ route('auth.register') }}" class="font-medium text-mobbi-pink hover:underline" wire:navigate>Registre-se</a></p>
    </div>
</div>