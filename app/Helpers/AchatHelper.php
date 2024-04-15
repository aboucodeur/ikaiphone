<?php

namespace App\Helpers;

use App\Models\Achat;

class AchatHelper
{
    public static function etatAchat(Achat $achat)
    {
        if (isset($achat)) {
            $etat = $achat->a_etat;
            return $etat < 1 ? 'En cours' : 'Valider';
        };
    }

    public static function paiementAchat(Achat $achat)
    {
        $paniers = $achat->iphones;
        $montant = 0;
        foreach ($paniers as $iph) $montant += $iph->pivot->ac_prix;
        return [$montant];
    }
}
