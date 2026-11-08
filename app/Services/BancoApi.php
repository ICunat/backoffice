<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class BancoApi
{
    private static function enviar($metodo, $caminho, $dados)
    {
        $url = config('services.banco.url') . $caminho;

        try {
            $pedido = Http::timeout(10)->acceptJson()->withToken(session('token'));

            if ($metodo == 'get') {
                $resposta = $pedido->get($url, $dados);
            } elseif ($metodo == 'post') {
                $resposta = $pedido->post($url, $dados);
            } else {
                $resposta = $pedido->put($url, $dados);
            }
        } catch (\Exception $e) {
            abort(503, 'Nao foi possivel contactar o servidor do banco.');
        }

        // Token invalido ou expirado: volta ao login
        if ($resposta->status() == 401) {
            session()->flush();
            throw new HttpResponseException(
                redirect()->route('login')->withErrors(['codigo' => 'A sessao expirou. Entre outra vez.'])
            );
        }

        return $resposta;
    }

    public static function get($caminho, $parametros = [])
    {
        return self::enviar('get', $caminho, $parametros);
    }

    public static function post($caminho, $dados = [])
    {
        return self::enviar('post', $caminho, $dados);
    }

    public static function put($caminho, $dados = [])
    {
        return self::enviar('put', $caminho, $dados);
    }

    // Texto de erro para mostrar ao funcionario
    public static function erro($resposta)
    {
        $mensagem = $resposta->json('message');
        if ($mensagem == null) {
            $mensagem = $resposta->json('erro');
        }
        if ($mensagem == null) {
            $mensagem = 'Pedido recusado pelo servidor (codigo ' . $resposta->status() . ').';
        }
        return $mensagem;
    }
}