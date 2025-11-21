<x-mail::message>
    # Novo Chamado de Suporte 🆘

    Você recebeu uma nova solicitação de suporte através da plataforma.

    <x-mail::panel>
        **De:** {{ $data['name'] }} ({{ $data['email'] }})
        **Assunto:** {{ $data['subject'] }}

        ---

        **Mensagem:** {{ $data['message'] }}
    </x-mail::panel>

    ### Dados de Contato:
    * **E-mail:** {{ $data['email'] }}
    @if(!empty($data['phone']))
        * **Telefone:** {{ $data['phone'] }}
    @endif
    * **Data:** {{ now()->format('d/m/Y H:i') }}

    Obrigado,<br>
    Sistema {{ config('app.name') }}
</x-mail::message>
