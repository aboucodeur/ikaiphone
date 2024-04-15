<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function index()
    {
        // Pas de systeme de corbeille
        $modeles =  Modele::query()->latest('created_at')->withCount('iphones')->get();
        return view('pages.modele.index', compact('modeles'));
    }

    public function create()
    {
        return view('pages.modele.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'],
            'm_memoire' => ['required'],
            'm_couleur' => ['required'],
            'm_prix' => ['required'],
        ]);
        $data['m_qte'] = 0;
        Modele::create($data);
        return redirect()->route('modele.index');
    }

    public function edit(Modele $modele)
    {
        return view('pages.modele.edit',  compact('modele'));
    }

    public function update(Request $request, Modele $modele)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'],
            'm_memoire' => ['required'],
            'm_couleur' => ['required'],
            'm_prix' => ['required'],
        ]);

        $modele->update($data);
        return redirect()->route('modele.index')->with('success', 'Modele mis à jour avec succès');
    }

    public function destroy(Modele $modele)
    {
        $modele->delete();
        return redirect()->route('modele.index')->with('success', 'Modele supprimé avec succès');
    }

    public function restore($id)
    {
        $modele = Modele::withTrashed()->findOrFail($id);
        $modele->restore();
        return redirect()->route('modele.index')->with('success', 'Modele restauré avec succès');
    }
}
