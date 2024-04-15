<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        /**
         * Peut etre ameliorer pour afficher un mini corbeille + restauration
         */
        $clients = Client::withTrashed()->get();
        return view('pages.client.index', compact('clients'));
    }

    public function create()
    {
        return view('pages.client.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'c_nom' => ['required', 'max:100'],
            'c_tel' => ['required', 'max:25'],
            'c_type' => ['required', 'max:25'],
            'c_adr' => ['required', 'min:10'],
        ]);
        Client::create($validatedData);
        return redirect()->route('client.index')->with('success', 'Client créé avec succès');
    }
    public function show(Client $client)
    {
        return view('pages.client.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('pages.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'c_nom' => ['required', 'max:100'],
            'c_tel' => ['required', 'max:25'],
            'c_type' => ['required', 'max:25'],
            'c_adr' => ['required'],
        ]);

        $client->update($validatedData);

        return redirect()->route('client.index')->with('success', 'Client mis à jour avec succès');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index')->with('success', 'Client supprimé avec succès');
    }

    public function restore($id)
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();
        return redirect()->route('client.index')->with('success', 'Client restauré avec succès');
    }
}
