<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function logar(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'pin'    => 'required',
        ]);

        $url = config('services.banco.url') . '/auth/login';

        try {
            $resposta = Http::timeout(10)->post($url, [
                'email'        => $request->codigo,
                'palavraPasse' => $request->pin,
            ]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['codigo' => 'Nao foi possivel contactar o servidor do banco.'])
                ->withInput();
        }

        if ($resposta->status() == 401) {
            return back()
                ->withErrors(['codigo' => 'Email ou palavra-passe incorretos.'])
                ->withInput();
        }

        if (!$resposta->successful()) {
            return back()
                ->withErrors(['codigo' => 'Erro no servidor do banco (codigo ' . $resposta->status() . ').'])
                ->withInput();
        }

        $dados = $resposta->json();

        session([
            'token' => $dados['token'],
            'email' => $request->codigo,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}