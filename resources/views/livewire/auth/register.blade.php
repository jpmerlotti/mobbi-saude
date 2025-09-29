<div>
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-mobbi-pink mb-6">Crie sua conta</h1>

        <form wire:submit.prevent="register" class="space-y-6">
            {{  $this->form }}

            <x-forms.button type="subimt" variant="primary">
                Registrar                
            </x-forms.button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Já tem uma conta? <a href="{{ route('auth.login') }}" class="font-medium text-mobbi-pink hover:underline" wire:navigate>Faça login</a></p>
    </div>
</div>