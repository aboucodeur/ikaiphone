<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(['id', 'u_prenom', 'u_nom', 'u_username', 'u_type', 'created_at']);
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

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

        User::create([
            'u_username' => $request->u_username,
            'u_prenom' => $request->u_prenom,
            'u_nom' => $request->u_nom,
            'u_type' => $request->u_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.edit');
    }
}
