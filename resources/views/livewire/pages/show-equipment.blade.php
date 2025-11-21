<div>
    <header class="bg-white shadow-sm">
        <div class="flex justify-between max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                Ver equipamento
            </h1>

            <x-back />
        </div>
    </header>
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">

            {{-- Coluna da Esquerda: Galeria de Imagens --}}
            <div class="mb-8 lg:mb-0">
                <div x-data="{ mainImage: '{{ $equipment->thumbnail }}' }">
                    {{-- Imagem Principal --}}
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100">
                        <img :src="mainImage" alt="{{ $equipment->name }}" class="w-full h-full object-center object-cover">
                    </div>

                    {{-- Thumbnails --}}
                    @if($equipment->images->count() > 1)
                        <div class="mt-4 grid grid-cols-5 gap-4">
                            @foreach($equipment->imageUrls() as $url)
                                <div @click="mainImage = '{{ $url }}'"
                                     class="cursor-pointer rounded-lg overflow-hidden border-2"
                                     :class="{ 'border-mobbi-blue': mainImage === '{{ $url }}', 'border-transparent': mainImage !== '{{ $url }}' }">
                                    <img src="{{ $url }}" alt="Thumbnail" class="w-full h-full object-center object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Coluna da Direita: Informações e Ações --}}
            <div>
                {{-- Nome e Tipo --}}
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $equipment->name }}</h1>
                <p class="mt-2 text-lg text-gray-500">{{ $equipment->equipmentType->name }}</p>

                {{-- Status --}}
                <div class="mt-4">
                    @if ($equipment->is_available)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Disponível
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        Indisponível
                    </span>
                    @endif
                </div>

                {{-- Descrição --}}
                <div class="mt-6 text-base text-gray-700 space-y-4">
                    {!! $equipment->description !!}
                </div>

                {{-- Bloco do Proprietário --}}
                <div class="mt-8 p-4 border-t border-b border-gray-200">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ $equipment->owner->avatar }}" alt="Avatar de {{ $equipment->owner->name }}">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Proprietário</div>
                            <div class="text-lg font-semibold text-gray-800">{{ $equipment->owner->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    @auth
                        @if( auth()->user()->id !== $equipment->owner->id && auth()->user()->hasCompletedProfile())
                            @if ($equipment->is_available)
                                <x-forms.button wire:click="rentalForm()" class="w-full text-lg">
                                    Solicitar Empréstimo
                                </x-forms.button>
                            @else
                                <p>Infelizmente esse equipamento não está disponível no momento :(</p>
                            @endif
                        @elseIf (! auth()->user()->hasCompletedProfile())
                            <p class="text-center text-bold">Seu perfil não está completo ainda.</p>
                            <p class="text-center text-bold">Para soliciatar um empréstimo, primeiro preencha todos os dados do seu perfil
                                <a href="{{ route('profile') }}"
                                    class="text-mobbi-blue font-bold underline">
                                    clicando aqui.
                                </a>
                            </p>
                        @else
                            <p class="text-center text-bold">Este é um dos seus equipamentos.</p>
                            <p class="text-center text-bold">Caso queira, você pode editar
                                <a href="{{ route('my-equipments.edit', ['equipment' => $equipment]) }}"
                                    class="text-mobbi-blue font-bold underline">
                                    clicando aqui.
                                </a>
                            </p>
                        @endif
                    @else
                        <a href="{{ route('auth.login') }}" wire:navigate class="w-full text-lg inline-flex items-center justify-center px-4 py-2 border rounded-md font-semibold text-sm tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 bg-mobbi-blue-600 border-transparent text-white hover:bg-mobbi-blue-700 focus:ring-mobbi-blue-500">
                            Faça login para solicitar
                        </a>
                    @endauth

                    @if(session('status'))
                        <p class="mt-4 text-center text-green-600">{{ session('status') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

    {{-- MODAL --}}
    <div x-data="{ show: @entangle('showModal') }"
        x-show="show"
        x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-1 overflow-y-auto"
        style="display: none;">

        <div class="flex items-center justify-center min-h-screen">
            {{-- Overlay --}}
            <div x-show="show"
                x-transition.opacity
                class="fixed inset-0 bg-black/75"></div>

            {{-- Conteúdo do Modal --}}
            <div x-show="show"
                x-transition @click.away="show = false"
                class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-4xl sm:w-full z-1">
                <form wire:submit="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 flex flex-col">
                        <div class="flex justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 text-start">
                                Solicitar empréstimo
                            </h3>
                            <x-forms.button type="button" variant="outlined" class="mr-3" @click="show = false">
                                Cancelar
                            </x-forms.button>
                        </div>
                        <div class="mt-6">
                            {{ $this->form }}
                        </div>
                        <div class="flex justify-end">
                            <x-terms.terms-slide-over />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
