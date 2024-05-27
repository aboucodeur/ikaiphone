<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeleController extends Controller
{
    // TODO : Adapter la fonction index pour prendre en compte l'entreprise
    public function index(Request $request)
    {
        // $modeles =  Modele::query()->latest('created_at')->withCount('iphones')->get();
        $en_id = Auth::user()->entreprise->en_id;
        $is_soft = $request->get('f') == "soft";
        $modeles = Modele::query()->latest('created_at')->where('en_id', $en_id)->withCount('iphones')->get();
        if ($is_soft) $modeles = Modele::onlyTrashed()->latest('created_at')->where('en_id', $en_id)->withCount('iphones')->get();
        return view('pages.modele.index', compact('modeles'));
    }

    public function create()
    {
        return view('pages.modele.create');
    }

    // TODO : Adapter la fonction store pour prendre en compte l'entreprise
    public function store(Request $request)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'], // a verifier
            'm_memoire' => ['required', 'numeric', 'min:32'], // a verifier
            'm_prix' => ['required', 'numeric', 'min:0'], // a verifier
        ]);
        $en_id = Auth::user()->entreprise->en_id;
        $data['m_qte'] = 0;
        $data['en_id'] = $en_id;
        Modele::create($data);
        return redirect()->route('modele.index');
    }

    // TODO : Adapter la fonction edit pour prendre en compte l'entreprise
    public function edit(Modele $modele)
    {
        if ($modele->en_id != Auth::user()->entreprise->en_id) return abort(404, 'Vous n\'êtes pas autorisé à modifier ce modèle');
        return view('pages.modele.edit',  compact('modele'));
    }

    public function update(Request $request, Modele $modele)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'], // a verifier
            'm_memoire' => ['required', 'numeric', 'min:32'], // a verifier
            'm_prix' => ['required', 'numeric', 'min:0'], // a verifier
        ]);

        $modele->update($data);
        return redirect()->route('modele.index')->with('success', 'Modele mis à jour avec succès');
    }

    // TODO : Adapter la fonction destroy pour prendre en compte l'entreprise
    public function destroy(Modele $modele)
    {
        if ($modele->en_id != Auth::user()->entreprise->en_id) return abort(404, 'Vous n\'êtes pas autorisé à supprimer ce modèle');
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
