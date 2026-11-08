<?php

namespace App\Http\Controllers;

use App\Services\BancoApi;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $parametros = [];
        if ($q != null && $q != '') {
            $parametros['q'] = $q;
        }

        $resposta = BancoApi::get('/clientes', $parametros);

        $clientes = $resposta->json();
        if (!is_array($clientes)) {
            $clientes = [];
        }

        return view('clientes.index', [
            'clientes' => $clientes,
            'q' => $q,
        ]);
    }

    public function create()
    {
        return view('clientes.form', ['cliente' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'bi'   => 'required',
        ]);

        $dados = $request->only(['nome', 'bi', 'telefone', 'email']);
        $resposta = BancoApi::post('/clientes', $dados);

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)])->withInput();
        }

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente criado com sucesso.');
    }

    public function edit($id)
    {
        $resposta = BancoApi::get('/clientes/' . $id);

        if (!$resposta->successful()) {
            return redirect()->route('clientes.index')
                ->withErrors(['api' => 'Cliente nao encontrado.']);
        }

        return view('clientes.form', ['cliente' => $resposta->json()]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'bi'   => 'required',
        ]);

        $dados = $request->only(['nome', 'bi', 'telefone', 'email']);
        $resposta = BancoApi::put('/clientes/' . $id, $dados);

        if (!$resposta->successful()) {
            return back()->withErrors(['api' => BancoApi::erro($resposta)])->withInput();
        }

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente actualizado com sucesso.');
    }
}