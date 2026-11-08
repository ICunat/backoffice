<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>{{ $cliente ? 'Editar cliente' : 'Novo cliente' }}</h1>
            <div class="sub">{{ $cliente ? 'Actualize os dados do cliente' : 'Preencha os dados do novo cliente' }}</div>
        </div>
    </x-slot>

    <div class="cartao form-estreito">

        <form method="POST"
              action="{{ $cliente ? route('clientes.update', $cliente['id']) : route('clientes.store') }}">
            @csrf
            @if ($cliente)
                @method('PUT')
            @endif

            <div class="campo">
                <label>Nome</label>
                <input type="text" name="nome" required class="entrada"
                       value="{{ old('nome', $cliente['nome'] ?? '') }}">
            </div>

            <div class="campo">
                <label>BI</label>
                <input type="text" name="bi" required class="entrada"
                       value="{{ old('bi', $cliente['bi'] ?? '') }}">
            </div>

            <div class="campo">
                <label>Telefone</label>
                <input type="text" name="telefone" class="entrada"
                       value="{{ old('telefone', $cliente['telefone'] ?? '') }}">
            </div>

            <div class="campo">
                <label>Email</label>
                <input type="text" name="email" class="entrada"
                       value="{{ old('email', $cliente['email'] ?? '') }}">
            </div>

            <div class="form-botoes">
                <button type="submit" class="btn btn-primario">Guardar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-claro">Cancelar</a>
            </div>
        </form>

    </div>
</x-app-layout>
