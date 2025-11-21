<div>
    <p class="mt-6 max-w-md text-end flex-1">Ao utilizar os serviços da
        <strong class="text-lg"><span class="text-mobbi-blue">Mobbi</span><span class="text-mobbi-pink">Saúde</span></strong>
        você declara que leu e está em total acordo com nossos
        <button class="text-mobbi-blue hover:underline text-lg font-medium"
            type="button"
            @click.prevent="$dispatch('open-slide-over', {title: 'Termos de Uso'});"
        >Termos de uso</button>.
    </p>

    <x-slide-over>
        <div class="prose prose-indigo lg:prose-lg text-gray-700 mx-auto">
            <x-terms.content />
        </div>
    </x-slide-over>
</div>
