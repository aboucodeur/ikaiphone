<?php

namespace App\Http\Controllers;

use App\Models\Iphone;
use App\Models\Retour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * C'est la partie la plus deliquat de l'application !
 * C'est quoi meme un retour ?
 *  Apres que un client a achete un iphone il voit des defauts la dessus
 *  il se rend a la boutique et l'on echange contre une nouvelle iphone .
 *
 *  Voici ses consequences sur le stock de l'entreprise
 *  -> L'ancien iphone est donne aux fournisseurs
 *  -> Le nouveaux iphone est considere comme vendu
 *  Donc -2 du stock de l'iphone
 *  -> Les commandes de l'ancien iphone sont supprimer
 *  -> Ainsi que les paiements
 *
 *
 */
class RetourController extends Controller
{
    public function index()
    {
        $en_id = auth()->user()->en_id;
        $datas_iphones = [];

        // filtrer par entreprise en joingant modele en verifant en_id
        $iphones = Iphone::with(['modele', 'ventes'])->whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', '=', $en_id);
        })->get();

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
        $retours = Retour::query()->latest('created_at')->get();
        return view('pages.retour.index', compact('retours', 'datas_iphones'));
    }

    // ! fix : Ajouter un retour d'iphone
    public function store(Request $request)
    {
        $en_id = auth()->user()->en_id;

        $datas = $request->validate([
            're_date' => 'required',
            're_motif' => 'nullable|string',
            'barcode' => 'required',
            'i_ech_id' => 'required',
        ]);

        // filtre par en en_id en joingant par modele en verifant modele.en_id
        $find_iphone = Iphone::with('modele')->where('i_barcode', '=', $datas['barcode'])->whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', '=', $en_id);
        })->first();

        $donnees = Iphone::with('ventes')->find($find_iphone->i_id);
        $is_not_same = $datas['barcode'] !== $datas['i_ech_id'];


        // echanger contre une nouvelle arrivage d'iphone
        $ids = Iphone::whereHas('retours')->pluck('i_id');
        $arrivages = Iphone::with(['modele'])
            ->whereHas('ventes', function ($query) {
                $query->havingRaw('COUNT(*) < 1');
            })
            ->where('modele.m_qte', '>', 0)
            ->whereNotIn('i_id', $ids)
            ->get();
        $ech_iphone = $arrivages->where('i_barcode', '=', $datas['i_ech_id'])->first();
        if ($donnees->ventes[0]->pivot && $is_not_same && isset($ech_iphone->i_id)) Retour::create([
            're_date' => $datas['re_date'],
            're_motif' => $datas['re_motif'],
            'i_id' => $find_iphone->i_id,
            'i_ech_id' => $ech_iphone->i_id,
            'en_id' => $en_id
        ]);
        return redirect()->route('retour.index');
    }

    // TODO : Valider le retour d'iphone
    public function validRetour(Retour $retour)
    {
        $en_id = auth()->user()->en_id;
        if ($retour->en_id !== $en_id) abort(403, 'Vous n\'êtes pas autorisé à faire ça !');

        // enlever -1 du stock de l'iphone (modele)
        $retour->update(['etat' => 1]);
        $retour->iphoneEchange->modele->update([
            'm_qte' => DB::raw('m_qte - 1')
        ]);

        $retour->iphoneRetourne->paiements()->delete();
        $retour->iphoneRetourne->ventes()->detach();
        return redirect()->route('retour.index');
    }

    public function destroy(Retour $retour)
    {
        $retour->forceDelete();
        return redirect()->route('retour.index');
    }
}
