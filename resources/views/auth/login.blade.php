<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Backoffice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/backoffice.css') }}?v={{ filemtime(public_path('css/backoffice.css')) }}">
</head>
<body>

    <div class="login-pagina">

        <div class="login-lado">
            <div class="marca-logo">{{ strtoupper(substr(config('app.name'), 0, 1)) }}</div>
            <h1>{{ config('app.name') }}</h1>
            <p>Backoffice para funcionários. Gestão de clientes, abertura de contas, depósitos e extractos.</p>
        </div>

        <div class="login-form-lado">
            <div class="login-caixa">
                <h2>Iniciar sessão</h2>
                <div class="sub">Entre com a sua conta de funcionário.</div>

                @if ($errors->any())
                    <div class="alerta alerta-erro">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="campo">
                        <label for="codigo">E-mail</label>
                        <input type="text" name="codigo" id="codigo" required class="entrada"
                               placeholder="admin@banco.com" value="{{ old('codigo') }}">
                    </div>

                    <div class="campo">
                        <label for="pin">Palavra-passe</label>
                        <input type="password" name="pin" id="pin" required class="entrada"
                               placeholder="Insira a sua palavra-passe">
                    </div>

                    <button type="submit" class="btn btn-primario">Entrar</button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>
