<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>Painel principal</h1>
        </div>
    </x-slot>

    <div class="boas-vindas">
        <h2>Bem-vindo ao {{ config('app.name') }}</h2>
        <p>Painel do funcionário. Escolha uma das opções para gerir o sistema.</p>
    </div>

    <div class="atalhos">

        <a href="{{ route('clientes.index') }}" class="atalho">
            <div class="atalho-icone ic-azul">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="4"/><path d="M2 21c0-4 3-7 7-7s7 3 7 7"/><path d="M17 4a4 4 0 010 8"/><path d="M22 21c0-3-2-5.5-5-6.5"/></svg>
            </div>
            <h3>Clientes</h3>
            <p>Criar, pesquisar e editar clientes do banco.</p>
            <span class="seta">Gerir clientes &rarr;</span>
        </a>

        <a href="{{ route('clientes.index') }}" class="atalho">
            <div class="atalho-icone ic-verde">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
            </div>
            <h3>Abertura de contas</h3>
            <p>Escolha o cliente e abra uma conta com PIN e saldo inicial.</p>
            <span class="seta">Escolher cliente &rarr;</span>
        </a>

        <a href="{{ route('contas.todas') }}" class="atalho">
            <div class="atalho-icone ic-roxo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="3"/><path d="M2 10h20"/><path d="M6 15h4"/></svg>
            </div>
            <h3>Contas</h3>
            <p>Ver saldos, bloquear ou desbloquear e consultar extractos.</p>
            <span class="seta">Ver contas &rarr;</span>
        </a>

        <a href="{{ route('depositos.form') }}" class="atalho">
            <div class="atalho-icone ic-amarelo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M4 21h16"/></svg>
            </div>
            <h3>Efectuar depósito</h3>
            <p>Registar depósitos em dinheiro numa conta activa.</p>
            <span class="seta">Fazer depósito &rarr;</span>
        </a>

    </div>
</x-app-layout>
