<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroVigilia;

class UserController extends Controller {
    public function salvarCadastro(Request $request) {
        $user = Auth::user();

        // Verificar se o usuário já fez cadastro
        if ($user->registroVigilia) {
            return redirect()->route('dashboard.user')->with('error', 'Você já completou seu cadastro. Não é possível cadastrar novamente.');
        }

        $request->validate([
            'cpf_rg' => ['required', 'string', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/'],
            'telefone' => ['required', 'string', 'regex:/^\(\d{2}\) \d{4,5}-\d{4}$/'],
            'idade' => 'required|integer',
            'lgpd' => 'accepted', // Checkbox LGPD obrigatório
        ], [
            'cpf_rg.regex' => 'CPF deve estar no formato 000.000.000-00.',
            'telefone.regex' => 'Telefone deve estar no formato (00) 00000-0000.',
        ]);

        $data = [
            'user_id' => $user->id,
            'idade' => $request->idade,
            'cpf_rg' => preg_replace('/\D/', '', $request->cpf_rg),
            'telefone' => preg_replace('/\D/', '', $request->telefone),
        ];

        if ($request->idade < 18) {
            $request->validate([
                'nome_responsavel' => 'required',
                'termo_autorizacao' => 'required|file|mimes:pdf,jpg,png|max:10240',
                'doc_responsavel' => 'required|file|mimes:pdf,jpg,png|max:10240',
            ]);
            
            $data['nome_responsavel'] = $request->nome_responsavel;
            $data['parentesco'] = $request->parentesco;
            $data['contato_responsavel'] = preg_replace('/\D/', '', $request->contato_responsavel);
            $data['termo_autorizacao_path'] = $request->file('termo_autorizacao')->store('documentos', 'public');
            $data['doc_responsavel_path'] = $request->file('doc_responsavel')->store('documentos', 'public');
        }

        RegistroVigilia::create($data);

        return redirect()->route('dashboard.user')->with('success', 'cadastro_concluido');
    }
}