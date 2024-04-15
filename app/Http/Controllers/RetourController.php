<?php

namespace App\Http\Controllers;

use App\Models\Iphone;
use App\Models\Retour;
use App\Models\Vendre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetourController extends Controller
{
    public function index()
    {
        $retours = Retour::query()->latest('created_at')->get();
        return view('pages.retour.index', compact('retours'));
    }

    public function create()
    {
        // contient les informations de chaque iphones pour faire de la recherche cote client !
        $datas_iphones = [];
        $iphones = Iphone::withCount('ventes')->get()->where('ventes_count', '>', 0);
        foreach ($iphones as $key => $iphone) {
            /**
             * La relation entre l'iphones et vendres est (n,n) -> vcommandes
             * Mais la commande est unique c'est pour cela qu'on permet de recuperer toujours la dernier
             */
            $v_count = $iphone->ventes->count();
            $vendre = $iphone->ventes[$v_count - 1];
            $datas_iphones[] = [
                'id' => $iphone->i_id,
                'modele' => $iphone->modele->m_nom,
                'type' => $iphone->modele->m_type,
                'memoire' => $iphone->modele->m_memoire,
                'barcode' => $iphone->i_barcode,
                'client' => $vendre->client->c_nom,
                'date_vente' => $vendre->pivot->created_at,
            ];
        }

        return view('pages.retour.create', compact('datas_iphones'));
    }

    public function store(Request $request)
    {
        $datas = $request->validate([
            're_date' => 'required',
            're_motif' => 'nullable|string',
            'barcode' => 'required',
            'i_ech_id' => 'required',
        ]);

        $find_iphone = Iphone::query()->where('i_barcode', '=', $datas['barcode'])->first();
        $iphone = Retour::withTrashed()->find($find_iphone->i_id); // 1 Verifier si retour
        $donnees = Iphone::with('ventes')->find($find_iphone->i_id); // 2 Verifier si commande
        $is_not_same = $datas['barcode'] !== $datas['i_ech_id']; // 3 Verifier si pas le meme iphonw

        // arrivage
        $ids = Iphone::withCount('retour')->get()->where('retour_count', '>', 0)->pluck('i_id');
        $arrivages = Iphone::with(['modele'])->withCount('ventes')->get()->where('ventes_count', '<', 1)->where('modele.m_qte', '>', 0);
        if (count($ids) > 0) $arrivages->whereNotIn('iphones.i_id', ...$ids);
        $ech_iphone = $arrivages->where('i_barcode', '=', $datas['i_ech_id'])->first();

        if (!isset($iphone) && $donnees->ventes[0]->pivot && $is_not_same) Retour::create([
            're_date' => $datas['re_date'],
            're_motif' => $datas['re_motif'],
            'i_id' => $find_iphone->i_id,
            'i_ech_id' => $ech_iphone->i_id,
        ]);
        return redirect()->route('retour.index');
    }

    public function validRetour(Retour $retour)
    {
        $retour->update(['etat' => 1]);
        $retour->iphoneEchange->modele->update([
            'm_qte' => DB::raw('m_qte - 1') // mettre a jour la quantite du modele
        ]);
        return redirect()->route('retour.index');
    }

    public function destroy(Retour $retour)
    {
        // forcer la suppression
        $retour->forceDelete();
        return redirect()->route('retour.index');
    }
}
