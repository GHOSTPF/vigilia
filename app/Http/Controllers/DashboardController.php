<?php

namespace App\Http\Controllers;

use App\Models\RegistroVigilia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $query = RegistroVigilia::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('nome_responsavel', 'like', "%{$search}%");
        }

        $totalRegistros = (clone $query)->count();

        $maiores = (clone $query)
            ->where('idade', '>=', 18)
            ->count();

        $menores = (clone $query)
            ->where('idade', '<', 18)
            ->count();

        if ($request->ordem == 'nome') {
            $query->join('users', 'registro_vigilias.user_id', '=', 'users.id')
                ->select('registro_vigilias.*')
                ->orderBy('users.name', 'asc');
        } elseif ($request->ordem == 'antigos') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $registros = $query->paginate(10)->withQueryString();

        return view('admin.painel', compact(
            'registros',
            'totalRegistros',
            'maiores',
            'menores'
        ));
    }

    public function index(Request $request)
    {
        $query = Registro::query()->with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('nome_responsavel', 'like', "%{$search}%");
        }

        if ($request->ordem == 'nome') {
            $query->join('users', 'registros.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc');
        } else {
            $query->latest();
        }


        $registros = $query->paginate(10);

        return view('dashboard', compact('registros'));
    }
}
