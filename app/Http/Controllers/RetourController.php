<?php

namespace App\Http\Controllers;

use App\Helpers\StockHelper;
use App\Models\Retour;
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
    // OK
    public function index()
    {
        $en_id = auth()->user()->en_id;
        $retours = Retour::query()->latest('created_at')->get();
        return view('pages.retour.index', compact('retours'));
    }

    // OK
    public function validRetour(Retour $retour)
    {
        $en_id = auth()->user()->en_id;
        if ($retour->en_id !== $en_id) abort(403, 'Vous n\'êtes pas autorisé à faire ça !');
        /**
         * Classique : on peut ameliorer apres !
         * L'iphone remplacer reste dans la boutique +1
         * L'iphone remplacant sort de la boutique -1
         */
        DB::transaction(function () use ($retour) {
            $retour->update(['etat' => 1]);
            StockHelper::iphoneUpdate($retour->iphoneEchange, 'V');
            // StockHelper::iphoneUpdate($retour->iphoneRetourne, 'E+1'); de maniere physque sa existe
        });
        return redirect()->route('retour.index');
    }

    public function destroy(Retour $retour)
    {
        $retour->forceDelete();
        return redirect()->route('retour.index');
    }
}
