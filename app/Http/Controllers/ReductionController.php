<?php

namespace App\Http\Controllers;

use App\Models\Reduction;
use Illuminate\Http\Request;

class ReductionController extends Controller
{
    public function index()
    {
        $reductions = Reduction::query()->latest('created_at')->get();;
        return view('pages.reduction.index', compact('reductions'));
    }

    public function create()
    {
        return view('pages.reduction.create');
    }

    public function store(Request $request)
    {
        $datas = $request->validate([
            'r_nom' => ['required', 'max:50', 'unique:reductions'],
            'r_type' => ['nullable', 'max:3'],
            'r_pourcentage' => ['required', 'numeric', 'between:0,80'],
        ]);

        Reduction::create($datas);
        return redirect()->route('reduction.index')->with('success', 'Réduction créée avec succès');
    }

    public function edit(Reduction $reduction)
    {
        return view('pages.reduction.edit', compact('reduction'));
    }

    public function update(Request $request, Reduction $reduction)
    {
        // dd($reduction);
        $datas = $request->validate([
            'r_nom' => ['required', 'max:50'],
            'r_type' => ['nullable', 'max:3'],
            'r_pourcentage' => ['required', 'numeric', 'between:0,100'],
        ]);

        $reduction->update($datas);
        return redirect()->route('reduction.index')->with('success', 'Réduction mise à jour avec succès');
    }

    public function destroy(Reduction $reduction)
    {
        $reduction->delete();
        return redirect()->route('reduction.index')->with('success', 'Réduction supprimée avec succès');
    }
}
