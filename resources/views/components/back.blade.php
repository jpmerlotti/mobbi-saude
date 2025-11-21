
@props([
    'url' => back()->getTargetUrl()
])

<x-forms.button variant="ghost">
    <a class="flex items-center gap-2" href="{{ $url }}" wire:navigate>
        <x-heroicon-o-arrow-left class="h-5 w-5"/>
        <span class="hidden sm:block">
            Voltar
        </span>
    </a>
</x-forms.button>
