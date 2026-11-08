<?php

namespace App\Http\Controllers;

use App\Services\BancoApi;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    // Contas de um cliente + formulario para abrir conta
    public function index($clienteId)
    {
        $respostaCliente = BancoApi::get('/clientes/' . $clienteId);
        if (!$respostaCliente->successful()) {
            return redirect()->route('clientes.index')
                ->withErrors(['api' => 'Cliente nao encontrado.']);
        }

        $respostaContas = BancoApi::get('/clientes/' . $clienteId . '/contas');
        $contas = $respostaContas->json();
        if (!is_array($contas)) {
            $contas = [];
        }

        return view('contas.index', [
            'cliente' => $respostaCliente->json(),
            'contas'  => $contas,
        ]);
    }

    // Abrir conta
    public function store(Request $request, $clienteId)
    {
        $request->validate([
            'pin'          => 'required|digits:4',
            'saldoInicial' => 'required|numeric|min:0',
        ]);

        $dados = [
            'pin'          => (string) $request->pin,
            'saldoInicial' => (float) $request->saldoInicial,
        ];

        $resposta = BancoApi::post('/clientes/' . $clienteId . '/contas', $dados);

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)])->withInput();
        }

        $numero = $resposta->json('numero');

        return redirect()->route('contas.index', $clienteId)
            ->with('sucesso', 'Conta aberta com sucesso. Numero da conta: ' . $numero);
    }

    // Detalhe da conta + extracto
    public function show($numero)
    {
        $respostaConta = BancoApi::get('/contas/' . $numero);
        if (!$respostaConta->successful()) {
            return redirect()->route('clientes.index')
                ->withErrors(['api' => 'Conta nao encontrada.']);
        }

        $respostaMov = BancoApi::get('/contas/' . $numero . '/movimentos');
        $movimentos = $respostaMov->json();
        if (!is_array($movimentos)) {
            $movimentos = [];
        }

        return view('contas.show', [
            'conta'      => $respostaConta->json(),
            'movimentos' => $movimentos,
        ]);
    }

    public function bloquear($numero)
    {
        $resposta = BancoApi::put('/contas/' . $numero . '/bloquear');

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)]);
        }

        return redirect()->route('contas.show', $numero)->with('sucesso', 'Conta bloqueada.');
    }

    public function desbloquear($numero)
    {
        $resposta = BancoApi::put('/contas/' . $numero . '/desbloquear');

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)]);
        }

        return redirect()->route('contas.show', $numero)->with('sucesso', 'Conta desbloqueada.');
    }

    // Pagina do cartao "Efectuar Deposito" do dashboard
    public function formDeposito()
    {
        return view('contas.deposito');
    }

    // Fazer deposito (usado na pagina da conta e na pagina de deposito)
    public function deposito(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'valor'  => 'required|numeric|min:0.01',
        ]);

        $numero = trim($request->numero);

        $resposta = BancoApi::post('/contas/' . $numero . '/depositos', [
            'valor' => (float) $request->valor,
        ]);

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)])->withInput();
        }

        $referencia = $resposta->json('referencia');

        return redirect()->route('contas.show', $numero)
            ->with('sucesso', 'Deposito efectuado. Referencia: ' . $referencia);
    }
}