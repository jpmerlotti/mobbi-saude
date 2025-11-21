<x-layouts.app :title="'Termos de Uso e Políticas'">
    <x-page-header title="Termos de Uso"></x-page-header>

    <div class="bg-gray-50">
        <div class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12">
                        <div class="text-center">
                            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                Termos de Uso e Políticas da MobbiSaúde
                            </h1>
                            <p class="mt-4 text-lg text-gray-500">
                                Última atualização: 15/11/2025
                            </p>
                        </div>

                        <x-terms.content />

                        @auth
                            <hr class="my-4">

                            <div class="flex flex-col items-center">
                            @if (! auth()->user()->terms_accepted_at)
                                <p class="text-center">
                                    Ao clicar em "Aceitar" durante o processo de locação, você confirma que leu, compreendeu e
                                    concorda em vincular-se a todos os termos e condições aqui estabelecidos.
                                </p>

                                <form action="{{ route('terms.accept') }}" method="POST"
                                class="flex justify-center mt-6">
                                    @csrf
                                    <x-forms.button>Aceitar</x-forms.button>
                                </form>
                            @else
                                <button disabled class="inline-flex items-center justify-center px-4 py-2 border rounded-md font-semibold text-sm tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150
                                    border-transparent text-white bg-green-700/50">Aceito em {{ auth()->user()->terms_accepted_at->format('d/m/Y H:i:s') }}</button>
                            @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
