<?php

// adapter le controller pour prendre en compte l'entreprise

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseurController extends Controller
{

    // TODO : Adapter la fonction index pour prendre en compte l'entreprise
    public function index()
    {
        $en_id = Auth::user()->entreprise->en_id;
        $fournisseurs = Fournisseur::where('en_id', $en_id)->get();
        return view('pages.fournisseur.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('pages.fournisseur.create');
    }

    // TODO : Adapter la fonction store pour prendre en compte l'entreprise
    public function store(Request $request)
    {
        $data = $request->validate([
            'f_nom' => ['required', 'max:100'],
            'f_tel' => ['max:25'],
            'f_adr' => '',
        ]);

        $en_id = Auth::user()->entreprise->en_id;
        $data['en_id'] = $en_id;

        Fournisseur::create($data);
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur créé avec succès');
    }


    // TODO : Adapter la fonction edit pour prendre en compte l'entreprise
    public function edit(Fournisseur $fournisseur)
    {
        // empecher a d'autres de modifier les données d'une autre entreprise
        if ($fournisseur->en_id != Auth::user()->entreprise->en_id) {
            return abort(403, 'Vous n\'êtes pas autorisé à modifier ce fournisseur');
        }
        return view('pages.fournisseur.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {

        $data = $request->validate([
            'f_nom' => ['required', 'max:100'],
            'f_tel' => ['max:25'],
            'f_adr' => '',
        ]);
        $fournisseur->update($data);
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur mis à jour avec succès');
    }

    // TODO : Adapter la fonction destroy pour prendre en compte l'entreprise
    public function destroy(Fournisseur $fournisseur)
    {
        // empecher a d'autres de supprimer les données d'une autre entreprise
        if ($fournisseur->en_id != Auth::user()->entreprise->en_id) {
            return abort(403, 'Vous n\'êtes pas autorisé à supprimer ce fournisseur');
        }
        $fournisseur->delete();
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur supprimé avec succès');
    }

    public function restore($id)
    {
        $fournisseur = Fournisseur::withTrashed()->findOrFail($id);
        $fournisseur->restore();
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur restauré avec succès');
    }
}
