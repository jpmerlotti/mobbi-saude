<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        /* Estilos básicos de reset para e-mail */
        body { font-family: sans-serif; margin: 0; padding: 0; background-color: #f3f4f6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; }
        .content { background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .footer { text-align: center; color: #9ca3af; font-size: 12px; padding-top: 20px; }
        .button { display: inline-block; padding: 10px 20px; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .panel { background-color: #f3f4f6; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 4px; }

        /* Cores utilitárias */
        .bg-blue { background-color: #3b82f6; }
        .bg-green { background-color: #10b981; }
        .bg-red { background-color: #ef4444; }
        .bg-gray { background-color: #6b7280; }
        .text-gray { color: #4b5563; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #1f2937; margin: 0;">{{ config('app.name') }}</h1>
        </div>

        <div class="content">
            {{ $slot }}
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
