<x-filament-panels::page>
    <form wire:submit.prevent="handle">
        <section class="flex flex-col gap-4">
            {{ $this->form }}
            <div class="flex justify-end">
                <div class="flex justify-end">
                    <x-filament::button type="submit" form="submit">
                        Trocar senha
                    </x-filament::button>
                </div>
            </div>
        </section>
    </form>
</x-filament-panels::page>
