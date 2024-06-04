<?php

namespace App\Helpers;

use App\Models\Iphone;
use App\Models\Vendre;

class VendreHelper
{
    public static function typeVente(Vendre $vendre)
    {
        if (isset($vendre)) {
            $vtype = $vendre->client->c_type;
            return $vtype === 'REVENDEUR' ? 'REVENDEUR' : 'SIMPLE';
        };
    }

    public static function etatVente(Vendre $vendre)
    {
        if (isset($vendre)) {
            $etat = $vendre->v_etat;
            return $etat < 1 ? 'En cours' : 'Valider';
        };
    }

    // OK
    public static function paiementVendre(Vendre $vendre)
    {
        $paniers = $vendre->iphones;
        $montant = 0;
        $payer = 0;
        $reste = 0;

        foreach ($paniers as $iph) {
            $etat = StockHelper::etat_fixe($iph); // prendre en compte seulement les iphones valider
            $montant += $etat === "valider" || $etat === "en cours" ?  $iph->pivot->vc_prix : 0; // prix de vente
            $paiements = $iph->paiements()->where('v_id', '=', $iph->pivot->v_id)->get(); // paiement de l'iphone pour la vente
            if ($etat === "valider" || $etat === "en cours") foreach ($paiements as $paiement) $payer += $paiement->vp_montant;
        }
        $reste = $montant - $payer;
        return [
            'montant' => $montant,
            'payer' => $payer,
            'reste' => $reste
        ];
    }

    // OK
    public static function paiementCommande(Iphone $iphone)
    {
        if (isset($iphone)) {
            $etat = StockHelper::etat_fixe($iphone); // prendre en compte seulement les iphones valider
            $cmontant = $etat === "valider" || $etat === "en cours" ? $iphone->pivot->vc_prix : 0; // prix de vente
            $paiements = $iphone->paiements()->where('v_id', '=', $iphone->pivot->v_id)->get(); // paiement de l'iphone pour la vente

            $cpayer = 0;
            $creste = 0;
            if ($etat === "valider" || $etat === "en cours") foreach ($paiements as $p) $cpayer += $p->vp_montant;
            $creste = $cmontant - $cpayer;
            return [
                'cmontant' => $cmontant,
                'cpayer' => $cpayer,
                'creste' => $creste
            ];
        }
    }
}
