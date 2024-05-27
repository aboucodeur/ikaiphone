<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    // TODO : Adapter la fonction pour prendre en compte l'entreprise
    public function index()
    {
        $en_id = Auth::user()->entreprise->en_id;
        // mettre a jour la variable users pour afficher les users de l'entreprise
        $users = User::where('en_id', $en_id)->get(['id', 'u_prenom', 'u_nom', 'u_username', 'u_type', 'created_at']);
        return view('pages.user.index', compact('users'));
    }

    // TODO : Adapter la fonction pour prendre en compte l'entreprise
    public function store(Request $request)
    {
        $request->validate([
            'u_username' => ['required', 'string', 'lowercase', 'alpha_num'],
            'u_prenom' => ['required'],
            'u_nom' => ['required'],
            'u_type' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $en_id = Auth::user()->entreprise->en_id;
        User::create([
            'u_username' => $request->u_username,
            'u_prenom' => $request->u_prenom,
            'u_nom' => $request->u_nom,
            'u_type' => $request->u_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'en_id' => $en_id
        ]);

        return redirect()->route('user.index');
    }
}
