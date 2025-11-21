@props([
    'title' => ''
])
<div
    x-data="{open: false, title: ''}"
    x-show="open"
    x-on:open-slide-over.window="open = true; title = $event.detail.title || '{{ $title }}'"
    x-on:close-slide-over.window="open = false"
    x-on:keydown.escape.window="open = false"
    class="relative z-50"
    style="display: none;"
>
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/75"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none overflow-hidden fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div
                    x-show="open"
                    x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto overflow-hidden w-screen max-w-4xl h-full"
                >
                    <div class="flex h-full flex-col bg-white shadow-xl">

                        <div class="bg-mobbi-blue-600 px-4 py-6 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-white" x-text="title">
                                    {{ $title }}
                                </h2>
                                <button @click="open = false" type="button" class="rounded-md text-blue-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                    <span class="sr-only">Fechar</span>
                                    <x-heroicon-o-x-mark class="h-6 w-6" />
                                </button>
                            </div>
                        </div>

                        <div class="relative flex-1 overflow-y-scroll p-6 sm:p-8">
                            {{ $slot }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
