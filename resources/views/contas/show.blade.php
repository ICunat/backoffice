<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Conta {{ $conta['numero'] ?? '' }}</h1>
            <div class="sub">Saldo, depósito e extracto</div>
        </div>
        <div class="acoes">
            <a href="{{ route('contas.todas') }}" class="btn btn-claro">&larr; Voltar às contas</a>
        </div>
    </x-slot>

    <div class="cartao-saldo">
        <div>
            <div class="rotulo">Saldo disponível</div>
            <div class="valor">{{ number_format((float) ($conta['saldo'] ?? 0), 2, ',', ' ') }} <small>MZN</small></div>
            <div class="conta-num">
                Conta {{ $conta['numero'] ?? '' }}
                @if (($conta['estado'] ?? '') == 'BLOQUEADA')
                    <span class="etiqueta etiqueta-bloq">Bloqueada</span>
                @else
                    <span class="etiqueta etiqueta-ok">Activa</span>
                @endif
            </div>
        </div>

        <div>
            @if (($conta['estado'] ?? '') == 'BLOQUEADA')
                <form method="POST" action="{{ route('contas.desbloquear', $conta['numero']) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sucesso">Desbloquear conta</button>
                </form>
            @else
                <form method="POST" action="{{ route('contas.bloquear', $conta['numero']) }}"
                      onsubmit="return confirm('Bloquear esta conta?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-perigo">Bloquear conta</button>
                </form>
            @endif
        </div>
    </div>

    <div class="cartao">
        <div class="cartao-titulo">Efectuar depósito</div>

        <form method="POST" action="{{ route('depositos.store') }}" class="form-linha" style="max-width:520px">
            @csrf
            <input type="hidden" name="numero" value="{{ $conta['numero'] }}">

            <div class="campo">
                <label>Valor (MZN)</label>
                <input type="number" name="valor" min="0.01" step="0.01" required class="entrada">
            </div>

            <button type="submit" class="btn btn-aviso">Depositar</button>
        </form>
    </div>

    <div>

        <div class="cartao">
            <div class="cartao-titulo">Extracto</div>

            <div class="tabela-caixa">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Referência</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th class="direita">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movimentos as $m)
                            @php
                                $entrada = (($m['contaDestino'] ?? '') == ($conta['numero'] ?? ''));
                            @endphp
                            <tr>
                                <td class="suave">{{ substr(str_replace('T', ' ', $m['dataHora'] ?? ''), 0, 16) }}</td>
                                <td><span class="etiqueta etiqueta-neutra">{{ $m['tipo'] ?? '' }}</span></td>
                                <td class="suave">{{ $m['referencia'] ?? '' }}</td>
                                <td class="suave">{{ $m['contaOrigem'] ?? '-' }}</td>
                                <td class="suave">{{ $m['contaDestino'] ?? '' }}</td>
                                <td class="direita {{ $entrada ? 'entrada-valor' : 'saida-valor' }}">
                                    {{ $entrada ? '+' : '-' }} {{ number_format((float) ($m['valor'] ?? 0), 2, ',', ' ') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="vazio">Ainda não há movimentos nesta conta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
