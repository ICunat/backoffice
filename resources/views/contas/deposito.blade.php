<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Efectuar depósito</h1>
            <div class="sub">Registar um depósito em dinheiro numa conta activa</div>
        </div>
    </x-slot>

    <div class="cartao form-estreito">

        <form method="POST" action="{{ route('depositos.store') }}">
            @csrf

            <div class="campo">
                <label>Número da conta</label>
                <input type="text" name="numero" required class="entrada" value="{{ old('numero') }}">
            </div>

            <div class="campo">
                <label>Valor (MZN)</label>
                <input type="number" name="valor" min="0.01" step="0.01" required class="entrada" value="{{ old('valor') }}">
            </div>

            <div class="form-botoes">
                <button type="submit" class="btn btn-aviso">Depositar</button>
            </div>
        </form>

        <p class="cartao-sub" style="margin:18px 0 0 0">
            Não sabe o número da conta? Abra <a href="{{ route('contas.todas') }}">Contas</a> e pesquise pelo nome do cliente.
        </p>

    </div>
</x-app-layout>
