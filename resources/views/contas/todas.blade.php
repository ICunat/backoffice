<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Contas</h1>
            <div class="sub">Todas as contas do banco</div>
        </div>
    </x-slot>

    <div class="cartao">

        <form method="GET" action="{{ route('contas.todas') }}" class="barra-pesquisa">
            <input type="text" name="q" value="{{ $q }}" class="entrada" placeholder="Pesquisar por número da conta ou nome do cliente">
            <button type="submit" class="btn btn-primario">Pesquisar</button>
            <a href="{{ route('contas.todas') }}" class="btn btn-claro">Limpar</a>
        </form>

        <p class="cartao-sub" style="margin-top:0">{{ count($contas) }} conta(s)</p>

        <div class="tabela-caixa">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Número da conta</th>
                        <th>Cliente</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th class="direita">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contas as $c)
                        <tr>
                            <td class="forte">{{ $c['numero'] ?? '' }}</td>
                            <td class="suave">{{ $c['cliente']['nome'] ?? '-' }}</td>
                            <td>{{ number_format((float) ($c['saldo'] ?? 0), 2, ',', ' ') }} MZN</td>
                            <td>
                                @if (($c['estado'] ?? '') == 'BLOQUEADA')
                                    <span class="etiqueta etiqueta-bloq">Bloqueada</span>
                                @else
                                    <span class="etiqueta etiqueta-ok">Activa</span>
                                @endif
                            </td>
                            <td class="direita acoes">
                                <a href="{{ route('contas.show', $c['numero']) }}">Extracto / Depositar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="vazio">Nenhuma conta encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
