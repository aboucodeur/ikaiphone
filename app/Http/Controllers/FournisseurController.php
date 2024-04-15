<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{

    public function index()
    {
        $fournisseurs = Fournisseur::withTrashed()->get();
        return view('pages.fournisseur.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('pages.fournisseur.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'f_nom' => ['required', 'max:100'],
            'f_tel' => ['required', 'max:25'],
            'f_adr' => ['required', 'min:10'],
        ]);
        Fournisseur::create($validatedData);
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur créé avec succès');
    }

    public function show(Fournisseur $fournisseur)
    {
        return view('pages.fournisseur.show', compact('fournisseur'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('pages.fournisseur.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $validatedData = $request->validate([
            'f_nom' => ['required', 'max:100'],
            'f_tel' => ['required', 'max:25'],
            'f_adr' => ['required'],
        ]);

        $fournisseur->update($validatedData);

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur mis à jour avec succès');
    }

    public function destroy(Fournisseur $fournisseur)
    {
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
