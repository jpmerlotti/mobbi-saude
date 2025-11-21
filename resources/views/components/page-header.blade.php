@props([
    'title',
    'backUrl' => true
])

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="text-lg leading-6 font-semibold sm:truncate text-gray-900">
                {{  $title }}
            </h1>

            <div class="flex items-center gap-2">
                @if ($backUrl)
                    <x-back />
                @endif

                @if ($slot->isNotEmpty())
                    <div class="">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
