<?php

namespace App\Http\Controllers;

use App\Models\RegistroVigilia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function user()
    {
        $user = Auth::user();
        $jaRegistrado = $user->registroVigilia ? true : false;

        return view('dashboard', ['jaRegistrado' => $jaRegistrado, 'registro' => $user->registroVigilia]);
    }

    public function admin(Request $request)
{
    // Use o nome correto do modelo: RegistroVigilia
    $query = RegistroVigilia::with('user');

    // Filtro de Busca por Nome (através do relacionamento user)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orWhere('nome_responsavel', 'like', "%{$search}%");
    }

    // Ordenação
    if ($request->ordem == 'nome') {
        $query->join('users', 'registro_vigilias.user_id', '=', 'users.id')
              ->select('registro_vigilias.*') // Evita sobrepor IDs
              ->orderBy('users.name', 'asc');
    } elseif ($request->ordem == 'antigos') {
        $query->oldest();
    } else {
        $query->latest();
    }

    // Use paginate para a paginação funcionar na View
    $registros = $query->paginate(10)->withQueryString();

    return view('admin.painel', compact('registros'));
}

    public function index(Request $request)
    {
        $query = Registro::query()->with('user');

        // Filtro de Busca por Nome (através do relacionamento user)
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('nome_responsavel', 'like', "%{$search}%");
        }

        // Ordenação
        if ($request->ordem == 'nome') {
            // Exemplo complexo: ordenar por nome do usuário relacionado
            $query->join('users', 'registros.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc');
        } else {
            $query->latest();
        }

        $registros = $query->paginate(10);

        return view('dashboard', compact('registros'));
    }
}
