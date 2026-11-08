<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Contas de {{ $cliente['nome'] ?? '' }}</h1>
            <div class="sub">BI {{ $cliente['bi'] ?? '' }} &middot; Tel. {{ $cliente['telefone'] ?? '-' }}</div>
        </div>
        <div class="acoes">
            <a href="{{ route('clientes.index') }}" class="btn btn-claro">&larr; Voltar aos clientes</a>
        </div>
    </x-slot>

    <div class="cartao">
        <div class="cartao-titulo">Contas abertas</div>

        <div class="tabela-caixa">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Número da conta</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th class="direita">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contas as $c)
                        <tr>
                            <td class="forte">{{ $c['numero'] ?? '' }}</td>
                            <td>{{ number_format((float) ($c['saldo'] ?? 0), 2, ',', ' ') }} MZN</td>
                            <td>
                                @if (($c['estado'] ?? '') == 'BLOQUEADA')
                                    <span class="etiqueta etiqueta-bloq">Bloqueada</span>
                                @else
                                    <span class="etiqueta etiqueta-ok">Activa</span>
                                @endif
                            </td>
                            <td class="direita acoes">
                                <a href="{{ route('contas.show', $c['numero']) }}">Abrir / Extracto</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="vazio">Este cliente ainda não tem contas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="cartao">
        <div class="cartao-titulo">Abrir nova conta</div>
        <div class="cartao-sub">Defina o PIN inicial (4 dígitos) e o saldo de abertura. O cliente deverá alterar o PIN no primeiro acesso.</div>

        <form method="POST" action="{{ route('contas.store', $cliente['id']) }}" class="form-linha">
            @csrf

            <div class="campo">
                <label>PIN (4 dígitos)</label>
                <input type="password" name="pin" maxlength="4" required inputmode="numeric" class="entrada">
            </div>

            <div class="campo">
                <label>Saldo inicial (MZN)</label>
                <input type="number" name="saldoInicial" min="0" step="0.01" required class="entrada"
                       value="{{ old('saldoInicial', '0') }}">
            </div>

            <button type="submit" class="btn btn-sucesso">Abrir conta</button>
        </form>
    </div>
</x-app-layout>
