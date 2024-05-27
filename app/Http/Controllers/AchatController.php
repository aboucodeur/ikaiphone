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

    // ! fix : Affiche les achats de l'entreprise donnee !
    public function index()
    {
        $en_id = auth()->user()->en_id;
        $frs = Fournisseur::query()->latest('created_at')->where('en_id', '=', $en_id)->get();
        $achats = Achat::whereHas('fournisseur', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->latest('created_at')->get();
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

    // ! fix : Affiche les modeles de l'entreprise donnee !
    public function show(Achat $achat)
    {
        $en_id = auth()->user()->en_id;
        $paniers = $achat->iphones;
        $modeles = Modele::query()->latest('created_at')->where('en_id', '=', $en_id)->get();
        return view('pages.achat.show', compact('achat', 'modeles', 'paniers'));
    }

    public function edit(Achat $achat)
    {
        $en_id = auth()->user()->en_id;
        $frs = Fournisseur::query()->latest('created_at')->where('en_id', '=', $en_id)->get();
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

    public function addCommande(Request $request, Achat $achat)
    {
        $datas = $request->validate([
            'prix' => ['numeric', 'required'],
            'i_barcode' => ['required'],
            'm_id' => ['required', 'exists:modeles,m_id']
        ]);


        // ! Improve performance : Add transaction to this operation !
        DB::transaction(function () use ($datas, $achat) {
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
        });

        return redirect()->back();
    }

    public function remCommande(Request $request, Achat $achat)
    {
        $i_id = $request->input('i_id');
        $achat->iphones()->detach([$i_id]);
        // supprimer l'iphone des arrivages une fois la commande supprimer
        Iphone::query()->findOrFail($i_id)->forceDelete();
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
