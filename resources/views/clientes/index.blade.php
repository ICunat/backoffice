<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Clientes</h1>
            <div class="sub">Cadastro, pesquisa e acesso às contas de cada cliente</div>
        </div>
        <div class="acoes">
            <a href="{{ route('clientes.create') }}" class="btn btn-primario">+ Novo cliente</a>
        </div>
    </x-slot>

    <div class="cartao">

        <form method="GET" action="{{ route('clientes.index') }}" class="barra-pesquisa">
            <input type="text" name="q" value="{{ $q }}" class="entrada" placeholder="Pesquisar por nome, BI ou telefone">
            <button type="submit" class="btn btn-primario">Pesquisar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-claro">Limpar</a>
        </form>

        <div class="tabela-caixa">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>BI</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th class="direita">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $c)
                        <tr>
                            <td class="suave">{{ $c['id'] ?? '' }}</td>
                            <td class="forte">{{ $c['nome'] ?? '' }}</td>
                            <td class="suave">{{ $c['bi'] ?? '' }}</td>
                            <td class="suave">{{ $c['telefone'] ?? '' }}</td>
                            <td class="suave">{{ $c['email'] ?? '' }}</td>
                            <td class="direita acoes">
                                <a href="{{ route('contas.index', $c['id']) }}">Contas</a>
                                <a href="{{ route('clientes.edit', $c['id']) }}">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="vazio">Nenhum cliente encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
