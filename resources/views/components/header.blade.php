<header class="bg-white shadow" x-data="{ open: false, profileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <x-logo />

            <nav class="hidden md:flex space-x-6 items-center">
                <a href="#" class="text-gray-600 hover:text-mobbi-pink transition-colors" wire:navigate>Serviços</a>
                <a href="{{ route('about-us') }}" class="text-gray-600 hover:text-mobbi-pink transition-colors" wire:navigate>Sobre Nós</a>
                @auth
                    <div class="relative ml-3">
                        <div @keydown.escape.window="profileOpen = false" @click.away="profileOpen = false">
                            <div>
                                <button @click="profileOpen = !profileOpen" type="button" class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mobbi-pink" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Abrir menu do usuário</span>
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->avatar }}" alt="Avatar de {{ auth()->user()->name }}">
                                </button>
                            </div>

                            <div x-show="profileOpen"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                style="display: none;"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="{{ route('profile') }}" wire:navigate role="menuitem" tabindex="-1" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" wire:navigate>Meu Perfil</a>
                                <a href="{{ route('my-equipments.index') }}" role="menuitem" tabindex="-1" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" wire:navigate>Meus Equipamentos</a>
                                <a href="{{ route('my-rentals.index') }}" role="menuitem" tabindex="-1" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" wire:navigate>Meus Empréstimos</a>
                                <form method="POST" action="{{ route('auth.logout') }}" role="menuitem" tabindex="-1">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('auth.login') }}" class="px-3 py-2 text-sm font-medium text-white bg-mobbi-pink rounded-md hover:bg-mobbi-blue transition-colors" wire:navigate>Entrar</a>
                    <a href="{{ route('auth.register') }}" class="block px-3 py-1 rounded-md text-base font-medium text-mobbi-blue border-2 border-mobbi-blue hover:border-mobbi-blue-700 hover:text-mobbi-blue-700" wire:navigate>Criar Conta</a>
                @endauth
            </nav>

            <div class="-mr-2 flex md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-mobbi-pink">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE -->
    <div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:leave="duration-200 ease-in" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" wire:navigate>Serviços</a>
            <a href="{{ route('about-us') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" wire:navigate>Sobre Nós</a>
            <div class="md:hidden border-b border-zinc-300"></div>
            @auth
                <div class="flex px-3 items-center mt-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar }}" alt="">
                    </div>
                    <div class="flex flex-col ml-3 justify-start">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" wire:navigate>Meu Perfil</a>
                    <a href="{{ route('my-equipments.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" wire:navigate>Meus Empréstimos</a>
                    <a href="{{ route('my-rentals.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" wire:navigate>Meus Empréstimos</a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Sair
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('auth.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-mobbi-pink hover:bg-mobbi-blue" wire:navigate>Entrar</a>
                <a href="{{ route('auth.register') }}" class="block px-3 py-2 rounded-md text-base font-medium border border-mobbi-blue hover:bg-mobbi-blue-700 text-mobbi-blue hover:text-mobbi-blue-700" wire:navigate>Criar Conta</a>
            @endauth
        </div>
    </div>
</header>
