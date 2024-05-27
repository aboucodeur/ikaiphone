<?php

namespace App\Helpers;

use App\Models\Iphone;
use App\Models\Vendre;

/**
 * * La fonction a simplifier l'utilisation
 * - Savoir le type de la vente : OK
 * - Savoir l'etat exacte de la vente : OK
 * - Savoir l'etat de paiement de la vente : montant total, payer et restante OK
 *
 * - Savoir l'etat exacte de la commande OK
 * - Savoir l'etat de paiement de la commande : montant total, payer et restane OK
 */

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

    public static function paiementVendre(Vendre $vendre)
    {
        // ()->get()
        $paniers = $vendre->iphones;

        $montant = 0;
        $payer = 0;
        $reste = 0;

        foreach ($paniers as $iph) {
            $montant += $iph->pivot->vc_prix;
            foreach ($iph->paiements()->where('v_id', '=', $iph->pivot->v_id)->get() as $paiement) {
                $payer += $paiement->vp_montant;
            }
        }
        $reste = $montant - $payer;

        return [
            'montant' => $montant,
            'payer' => $payer,
            'reste' => $reste
        ];
    }

    public static function etatCommande(Vendre $vendre, Iphone $iphone)
    {
        if (isset($vendre) && isset($iphone)) {
            $vtype = $vendre->v_type;
            $infos_vente = self::paiementVendre($vendre);
            $etat = $iphone->pivot->vc_etat; // ici c'est la commande pivot table
            /**
             * Si simple : 0 ou 1
             * Si revendeur : 0 ou 1 ou 2 ou 3
             */
            if ($vtype === 'SIM') return ($etat < 1 ? 'En cours' : 'Valider');
            if ($vtype === 'REV') return ($etat == 0 ? 'En cours' : ($etat == 1 ? 'Valider' : (($etat == 2 || $infos_vente['reste'] == 0) ? 'Vendu' : 'Rendu')));
        }
    }

    public static function paiementCommande(Iphone $iphone)
    {
        if (isset($iphone)) {
            $cmontant = $iphone->pivot->vc_prix;
            $cpayer = 0;
            $creste = 0;

            foreach ($iphone->paiements()->where('v_id', '=', $iphone->pivot->v_id)->get() as $p) {
                $cpayer += $p->vp_montant;
            }
            $creste = $cmontant - $cpayer;

            return [
                'cmontant' => $cmontant,
                'cpayer' => $cpayer,
                'creste' => $creste
            ];
        }
    }
}
