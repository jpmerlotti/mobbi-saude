<footer class="bg-gray-50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-8">
            {{-- Coluna de Branding --}}
            <div class="md:col-span-2 lg:col-span-2">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-mobbi-blue" wire:navigate>
                    Mobbi<span class="text-mobbi-pink">Saúde</span>
                </a>
                <p class="mt-4 text-base text-gray-500">
                    Conectando cuidado e comunidade através do compartilhamento de equipamentos de saúde.
                </p>
                <div class="mt-6 flex space-x-4">
                    {{-- Ícone do Facebook --}}
                    <a href="#" class="text-gray-400 hover:text-mobbi-pink transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    {{-- Ícone do Instagram --}}
                    <a href="#" class="text-gray-400 hover:text-mobbi-pink transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0-2a7 7 0 110 14 7 7 0 010-14zm6.406-1.185a1.285 1.285 0 100 2.57 1.285 1.285 0 000-2.57z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Coluna de Navegação --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Navegação</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Equipamentos</a></li>
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Serviços</a></li>
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Sobre Nós</a></li>
                </ul>
            </div>

            {{-- Coluna de Ajuda --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Ajuda</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Contato</a></li>
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">FAQ</a></li>
                </ul>
            </div>

            {{-- Coluna Legal --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Legal</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Termos de Serviço</a></li>
                    <li><a href="#" class="text-base text-gray-500 hover:text-mobbi-pink transition-colors">Política de Privacidade</a></li>
                </ul>
            </div>
        </div>

        {{-- Barra de Copyright --}}
        <div class="mt-12 border-t border-gray-200 pt-8">
            <p class="text-base text-gray-400 text-center">&copy; {{ date('Y') }} MobbiSaúde. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>