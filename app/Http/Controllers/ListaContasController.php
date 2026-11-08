<?php

namespace App\Http\Controllers;

use App\Services\BancoApi;
use Illuminate\Http\Request;

class ListaContasController extends Controller
{
    public function index(Request $request)
    {
        $resposta = BancoApi::get('/contas');

        $contas = $resposta->json();
        if (!is_array($contas)) {
            $contas = [];
        }

        // Pesquisa por numero da conta ou nome do cliente
        $q = trim((string) $request->query('q', ''));

        if ($q != '') {
            $filtradas = [];
            foreach ($contas as $c) {
                $numero = (string) ($c['numero'] ?? '');
                $nome = (string) ($c['cliente']['nome'] ?? '');

                if (stripos($numero, $q) !== false || stripos($nome, $q) !== false) {
                    $filtradas[] = $c;
                }
            }
            $contas = $filtradas;
        }

        return view('contas.todas', [
            'contas' => $contas,
            'q'      => $q,
        ]);
    }
}