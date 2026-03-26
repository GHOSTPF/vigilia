<?php

namespace App\Http\Controllers;

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
}
