<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - Backoffice</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/backoffice.css') }}?v={{ filemtime(public_path('css/backoffice.css')) }}">
    </head>
    <body>
        <div class="app">

            @include('layouts.navigation')

            <div class="principal">

                @isset($header)
                    <div class="topo">
                        {{ $header }}
                    </div>
                @endisset

                <div class="conteudo">
                    @if (session('sucesso'))
                        <div class="alerta alerta-sucesso">{{ session('sucesso') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alerta alerta-erro">
                            <ul>
                                @foreach ($errors->all() as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
