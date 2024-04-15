<?php

namespace App\Http\Controllers;

use App\Models\Iphone;
use App\Models\Modele;
use Illuminate\Http\Request;

class IphoneController extends Controller
{
    public function index()
    {
        // Pas de systeme de corbeille
        $iphones = Iphone::all();
        $modeles = Modele::query()->latest('created_at')->get();
        return view('pages.iphone.index', compact('iphones', 'modeles'));
    }

    public function create()
    {
        // sans prendre les modele supprimer
        $modeles = Modele::query()->latest('created_at')->get();
        return view('pages.iphone.create', compact('modeles'));
    }

    public function store(Request $request)
    {

        $datas = $request->validate([
            'i_barcode' => ['required', 'string', 'max:100'],
            'm_id' => ['required', 'exists:modeles,m_id'],
        ]);
        Iphone::create($datas);
        return redirect()->route('iphone.index');
    }

    public function edit(Iphone $iphone)
    {
        $modeles = Modele::query()->latest('created_at')->get();
        return view('pages.iphone.edit', compact('iphone', 'modeles'));
    }

    public function update(Request $request, Iphone $iphone)
    {
        $datas = $request->validate([
            'i_barcode' => ['required', 'string', 'max:100'],
            'm_id' => ['required', 'exists:modeles,m_id'],
        ]);

        $iphone->update($datas);
        return redirect()->route('iphone.index');
    }

    public function destroy(Iphone $iphone)
    {
        $iphone->delete();
        return redirect()->route('iphone.index');
    }

    public function restore(String $id)
    {
        $iphone = Iphone::withTrashed()->findOrFail($id);
        $iphone->restore();
        return redirect()->route('modele.index')->with('success', 'Iphone restauré avec succès');
    }
}
