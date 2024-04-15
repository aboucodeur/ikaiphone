<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Fournisseur;
use App\Models\Iphone;
use App\Models\Modele;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatController extends Controller
{

    public function index()
    {

        $frs = Fournisseur::withTrashed()->latest('created_at')->get();
        $achats = Achat::query()->latest('created_at')->get();
        return view('pages.achat.index', compact('achats', 'frs'));
    }

    public function create()
    {
        return view('pages.achat.create');
    }

    public function store(Request $request)
    {
        $datas = $request->validate([
            'a_date' => ['required', 'date'],
            'f_id' => ['required', 'exists:fournisseurs,f_id']
        ]);
        $datas['a_etat'] = 0;
        $a = Achat::create($datas);
        return redirect()->route('achat.show', $a);
    }

    public function show(Achat $achat)
    {
        $paniers = $achat->iphones;
        $modeles = Modele::withTrashed()->latest('created_at')->get();
        return view('pages.achat.show', compact('achat', 'modeles', 'paniers'));
    }

    public function edit(Achat $achat)
    {
        $frs = Fournisseur::withTrashed()->latest('created_at')->get();
        return view('pages.achat.edit', compact('achat', 'frs'));
    }

    public function update(Request $request, Achat $achat)
    {
        $datas = $request->validate([
            'a_date' => ['required', 'date'],
            'f_id' => ['required', 'exists:fournisseurs,f_id']
        ]);
        $achat->update($datas);
        return redirect()->route('achat.index');
    }

    public function destroy(Achat $achat)
    {
        $achat->delete();
        return redirect()->route('achat.index');
    }

    // ** Fonctionnalites avancee de l'achat ici ! comme la gestion des commandes
    public function addCommande(Request $request, Achat $achat)
    {
        $datas = $request->validate([
            'prix' => ['numeric', 'required'],
            'i_barcode' => ['required'],
            'm_id' => ['required', 'exists:modeles,m_id']
        ]);

        $iphone = Iphone::create([
            'i_barcode' => $datas['i_barcode'],
            'm_id' => $datas['m_id']
        ]);

        $achat->iphones()->attach($iphone['i_id'], [
            'ac_etat' => 0,
            'ac_qte' => 1,
            'ac_prix' => $datas['prix'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back();
    }

    public function remCommande(Request $request, Achat $achat)
    {
        $i_id = $request->input('i_id');
        $achat->iphones()->detach([$i_id]);
        Iphone::query()->findOrFail($i_id)->forceDelete(); // suppression forcer de l'arrivage
        return redirect()->back();
    }

    public function validCommande(Achat $achat)
    {
        if ($achat->a_etat < 1) {
            $achat->update(['a_etat' => 1]);
            $iphones = $achat->iphones;

            foreach ($iphones as $iphone) {
                $iphone->pivot->update(['ac_etat' => 1]);
                $iphone->modele->update(['m_qte' => DB::raw('m_qte + 1')]);
            }
        }
        return redirect()->back();
    }
}
