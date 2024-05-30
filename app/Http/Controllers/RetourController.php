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
        $retours = Retour::query()->latest('created_at')->get();
        return view('pages.retour.index', compact('retours'));
    }

    public function checkIphone(Request $request)
    {
        $en_id = auth()->user()->en_id;
        $iphone = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->where('i_barcode', '=', $request->barcode ? $request->barcode : $request->i_ech_id)->first();


        $html = '';
        if (!isset($iphone)) $html = '<p class="m-0 text-center text-danger">Aucun iPhone trouvé</p>';
        else {
            $vendre = $iphone?->ventes->first() ? $iphone?->ventes->first() : null;
            if ($vendre)  $html = '
                                <h5 class="m-0">Infos iPhone </h5>
                                <p class="m-0">Nom du modele : ' . $iphone->modele->m_nom . '</p>
                                <p class="m-0">Type : ' . $iphone->modele->m_type . '</p>
                                <p class="m-0">Memoire : ' . $iphone->modele->m_memoire . '</p>
                                <p class="m-0">Client : ' . $vendre?->client->c_nom . ' </p>
                                <p class="m-0">Vendu aux prix : ' . $vendre?->pivot->vc_prix . ' </p>
                                <p class="m-0">Date : ' . $vendre?->pivot->created_at . '</p>
                            ';
            else    $html = '
                            <h5 class="m-0">Arrivage iPhone </h5>
                            <p class="m-0">Nom du modele : ' . $iphone->modele->m_nom . '</p>
                            <p class="m-0">Type : ' . $iphone->modele->m_type . '</p>
                            <p class="m-0">Memoire : ' . $iphone->modele->m_memoire . '</p>
                        ';
        }

        return response($html, 200)->header('Content-Type', 'text/html');
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
        $ids = Iphone::withCount('retour')->get()->where('retour_count', '>', 0)->pluck('i_id');
        $arrivages = Iphone::with(['modele'])
            ->withCount('ventes')
            ->get()
            ->where('ventes_count', '<', 1)
            ->where('modele.m_qte', '>', 0)
            ->where('modele.en_id', '=', $en_id);
        if (count($ids) > 0) $arrivages->whereNotIn('iphones.i_id', ...$ids);
        $ech_iphone = $arrivages->where('i_barcode', '=', $datas['i_ech_id'])->first();


        // ! Lors de l'implementation d'une petite fonctionnalite je viens de voir une grosse probleme dans l'application !
        // des problemes peut apparaitre ici il peut faire expres de ne pas valider la premiere et valider la deuxieme
        // or que je veux juste savoir si l'iphone a ete vendu ou pas
        // mais la contrainte de la base de donnee empeche d'ajouter deux fois l'iphone sauf si on supprimer donc sa marche encore !
        // pour retourner l'iphone il faut que l'iphone ait ete vendu donc la commande valider
        // j'ai vus cet probleme dans lapplication : Peut venir si les contraintes ne sont pas appliquer
        if ($donnees->ventes[0]->pivot->vc_etat > 0 && $is_not_same && isset($ech_iphone->i_id)) Retour::create([
            're_date' => $datas['re_date'],
            're_motif' => $datas['re_motif'],
            'i_id' => $find_iphone->i_id,
            'i_ech_id' => $ech_iphone->i_id,
            'en_id' => $en_id
        ]);
        return redirect()->route('retour.index');
    }

    public function validRetour(Retour $retour)
    {
        $en_id = auth()->user()->en_id;
        if ($retour->en_id !== $en_id) abort(403, 'Vous n\'êtes pas autorisé à faire ça !');
        // enlever -1 du stock de l'iphone (modele)
        DB::transaction(function () use ($retour) {
            $retour->update(['etat' => 1]);
            $retour->iphoneEchange->modele->update([
                'm_qte' => DB::raw('m_qte - 1')
            ]);
            // supprimer les paiements et les commandes de ventes
            $retour->iphoneRetourne->paiements()->delete();
            $commandes = $retour->iphoneRetourne->ventes->pluck('v_id');
            $retour->iphoneRetourne->ventes()->detach([...$commandes]);
        });


        return redirect()->route('retour.index');
    }

    public function destroy(Retour $retour)
    {
        $retour->forceDelete();
        return redirect()->route('retour.index');
    }
}
