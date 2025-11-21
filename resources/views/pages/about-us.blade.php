<x-layouts.app :title="'about-us'">
    <x-page-header title="Sobre nós"></x-page-header>
    {{-- Seção 1: Hero --}}
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                <span class="text-mobbi-blue">Nossa História:</span>
                <span class="block text-mobbi-pink">Um Projeto Nascido da Vontade de Ajudar.</span>
            </h1>
            <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-500">
                A MobbiSaúde não é apenas uma plataforma, é um movimento. Um Trabalho de Graduação que se tornou uma missão para conectar cuidado e comunidade.
            </p>
        </div>
    </div>

    {{-- Seção 2: O Projeto TG --}}
    <div class="py-16 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-mobbi-pink tracking-wide uppercase">Nosso Propósito</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                    Um Trabalho de Graduação com Impacto Real
                </p>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">
                    Este projeto nasceu como nosso **Trabalho de Graduação (TG)** no curso de Análise e Desenvolvimento de Sistemas. Identificamos uma necessidade real: a dificuldade e o alto custo para obter equipamentos de saúde para recuperações temporárias. A MobbiSaúde é nossa resposta a esse desafio, aplicando tecnologia para criar uma solução de impacto social.
                </p>
            </div>
        </div>
    </div>

    {{-- Seção 3: Os Idealizadores --}}
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Os Idealizadores</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">
                    Conheça os estudantes por trás do projeto MobbiSaúde.
                </p>
            </div>
            <div class="mt-12 mx-auto grid max-w-lg gap-10 lg:grid-cols-2 lg:max-w-none">
                {{-- Card do Igor --}}
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-56 w-full object-contain bg-neutral-300" src="{{ asset('img/IgorVinturini.png') }}" alt="Foto de Igor Gabriel Vinturini">
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-mobbi-pink">Co-fundador</p>
                            <a href=""><h3 class="mt-2 text-2xl font-semibold text-gray-900">Igor Gabriel Vinturini</h3></a>
                            <p class="mt-3 text-base text-gray-500">Apaixonado por criar experiências de usuário intuitivas e por transformar ideias em realidade através do código, com um olhar especial para projetos que fazem a diferença.</p>
                        </div>
                    </div>
                </div>
                {{-- Card do João Pedro --}}
                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-56 w-full object-contain bg-neutral-300" src="{{ asset('img/JoaoMerlotti.jpg') }}" alt="Foto de João Pedro Merlotti">
                    </div>
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-mobbi-pink">Co-fundador</p>
                            <a href="https://linkedin.com/in/jpmerlotti" target="_blank"><h3 class="mt-2 text-2xl font-semibold text-gray-900">João Pedro Merlotti</h3></a>
                            <p class="mt-3 text-base text-gray-500">Entusiasta de tecnologia e solucionador de problemas, focado em construir aplicações eficientes e escaláveis com a TALL Stack para gerar impacto positivo na comunidade.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Seção 4: FATEC Jales --}}
    <div class="bg-mobbi-blue-600">
        <div class="flex flex-col max-w-7xl mx-auto py-16 px-4 sm:py-20 sm:px-6 lg:px-8 text-center justify-center items-center">
            <h2 class="text-3xl font-extrabold text-neutral-50">
                Nossa Casa Acadêmica
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Este projeto é fruto do conhecimento e do apoio recebido na <br><a href="https://fatecjales.edu.br" target="_blank" class="text-neutral-200 hover:underline hover:text-neutral-100"><strong>Faculdade de Tecnologia de Jales - Prof. José Camargo</strong></a>.
            </p>
            <p class="mt-6 text-base text-indigo-200">
                Agradecemos a todos os professores e à instituição por serem o berço acadêmico da MobbiSaúde.
            </p>
            <p class="mt-6 text-base text-indigo-200">
                Em especial a nosso orientador <a class="hover:underline text-neutral-200 hover:text-neutral-100" target="__blank" href="https://www.linkedin.com/in/cristianopiresmartins">
                    <strong>Cristiano Pires Martins</strong></a>.
            </p>
            <div class="mt-6 p-4 bg-neutral-100 rounded-md shadow-md">
                <img src="{{ asset('img/tio_cris.jpeg') }}" alt="Foto do Tio Cris" class="h-56 w-48 border-2 border-black rounded-md ">
            </div>
        </div>
    </div>
</x-layouts.app>
