<?php

namespace App\Http\Controllers;

// Faire le meme comme celui de FournisseurController

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // TODO : Adapter la fonction index pour prendre en compte l'entreprise
    public function index()
    {
        // afficher les clients de l'entreprise donner
        $en_id = Auth::user()->entreprise->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', $en_id)->get();
        return view('pages.client.index', compact('clients'));
    }

    public function create()
    {
        return view('pages.client.create');
    }

    // TODO : Adapter la fonction store pour prendre en compte l'entreprise
    public function store(Request $request)
    {

        $data = $request->validate([
            'c_nom' => ['required', 'max:100'],
            'c_type' => ['required', 'max:25'],
            'c_adr' => ['min:5'],
            'c_tel' => ['max:25'],
        ]);
        $en_id = Auth::user()->entreprise->en_id;
        $data['en_id'] = $en_id;
        Client::create($data);
        return redirect()->route('client.index')->with('success', 'Client créé avec succès');
    }

    // TODO : Adapter la fonction storeFast pour prendre en compte l'entreprise
    public function storeFast(Request $request)
    {
        $data = $request->validate([
            'c_nom' => ['required', 'max:100'],
            'c_type' => ['required', 'max:25'],
            'c_adr' => [''],
            'c_tel' => ['max:25'],
        ]);
        $en_id = Auth::user()->entreprise->en_id;
        $data['en_id'] = $en_id;
        Client::create($data);
        return redirect()->route('vendre.index')->with('success', 'Client créé avec succès');
    }

    public function show(Client $client)
    {
        return view('pages.client.show', compact('client'));
    }

    // TODO : Adapter la fonction edit pour prendre en compte l'entreprise
    public function edit(Client $client)
    {
        // empecher d'autres entreprises de modifier le client
        $en_id = Auth::user()->entreprise->en_id;
        if ($client->en_id != $en_id) {
            return abort(403, 'Vous n\'êtes pas autorisé à modifier ce client');
        }
        return view('pages.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'c_nom' => ['required', 'max:100'],
            'c_adr' => ['required', 'min:10'],
            'c_adr' => ['min:5'],
            'c_tel' => ['max:25'],
        ]);

        $client->update($data);
        return redirect()->route('client.index')->with('success', 'Client mis à jour avec succès');
    }


    // TODO : Adapter la fonction destroy pour prendre en compte l'entreprise
    public function destroy(Client $client)
    {
        // empecher d'autres entreprises de supprimer le client
        $en_id = Auth::user()->entreprise->en_id;
        if ($client->en_id != $en_id) {
            return abort(403, 'Vous n\'êtes pas autorisé à supprimer ce client');
        }
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
