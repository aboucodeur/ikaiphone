<?php

namespace App\Helpers;

use App\Models\Iphone;
use Illuminate\Support\Facades\DB;

/**
 *
 * ! La seule limite se trouve dans la tete quand tu comprends le probleme
 * ! bien sure tu peux la coder et ses challenge.
 *
 * Vas permettre de suivre les mouvements que fait le produit en temps reel
 * ici c'est l'iphone. Et aussi repondre aux besoins reels que resent
 * les clients dans la vente de telephone en gerant les vas et viens du meme produit.
 *
 * Problematique : Cette module est le coeur de l'application
 * - Un iphone peut ne pas avoir de commande exemple : retour remplacant
 * - Un iphone peut etre les deux (retour & retourner ) ? => comparaison date
 * - Maintenir la coherence des datas : fait la beaute de l'algorithme
 *      - remplacer  : pas vendu         si type_retour
 *      - remplacant : vendu ou echanger si retour annuler
 *
 * ! Probleme  de derniers minutes que j'ai rencontrer : il traite les commandes du meme iphone comme etant la derniere
 * ! la solution que je vois ici est la suivante :
 *  Vu que le vc_etat evolue avec la commande nous aurons besoins de recuperer l'etat fixe de la commande
 *  C'est le moyen ici qui vas nous permettre d'isoler la commande ici !

 *  Parceque nous utilisons l'etat dynamique qui empechant l'iphone
 *  la verification de l'iphone de maniere de fixe
 *
 * Utiliser l'etat fixe pour ameliorer l'interaction avec les boutons pourquoi pas dynamique
 * le meme probleme revient en cours
 *  - rendre : on peut pas si etat > 2
 *  - echanger : on peut pas si etat = 3 la seule moyen ici juste faire un match si c'est is_latest
 *      pour masquer le bouton a l'utilisateur et ne pas pourrir les donnees
 *  - encore plus savoir l'etat en temps reel de l'iphone au niveaux du stock
 *      -100 pour dire que c'est remplacer (sans commande)
 *      -200 pour dire que c'est pas encore vendu
 *
 * Avec ce code j'ai appris que creer une module qui gerer et factorise la logique
 * est compliquer a faire mais simplifie l'implementation des fonctionnalites complexes
 * et rend le code plus modulable et ajout de bloc est plus simple et facile a faire
 * le probleme est de bien comprendre le probleme avant de la code (meilleure amie c'est le papier)
 *
 */
class StockHelper
{
    /**
     * Etat de l'iphone
     * Aves ses informations nous allons interagir avec le stock !
     * - En augmentant la quantite de -1 ou +1
     * - Supprimer ou pas les paiements
     * - Re-faire les calculs en se basant seulement sur les commandes dont l'etat est 1
     *
     * Sorties : OK
     *  - Action                     : Vendre (V), Echanger (E), Rendre (R), VIDE
     *  - Etat                       : 0,1,2,3
     *
     *  Interactions : OK
     *  1- Valider la commande (-1) OK
     *  2- Rendre / Refuser    (+1) OK
     *  3- Echanger            (-1 ou +1) OK
     *  - Valider le retour    (-1) - OK
     *  - + Retour annuler     (+1) - en cours
     *  - + Donner aux fournisseur (-1) - en cours
     */
    public static function iphoneEtat(Iphone | null $iphone)
    {
        $sorties = [];

        if (isset($iphone) && $iphone->i_id) {
            $modele = $iphone->modele; // modele de l'iphone

            $sorties = [
                'modele' => $modele,
                'action' => [],
                'etat' => null,
                'is_latest' => '', // date du dernier vente
            ];

            $vente = $iphone->ventes()->latest('created_at')->first();
            $retour = $iphone->retour()->latest('created_at')->first();
            $retourner = $iphone->retourner()->latest('created_at')->first();

            // ! fix major bugs :  la date du dernier commande pour tester la crediblite des ventes
            $sorties['is_latest'] = $vente?->pivot?->created_at == $iphone?->pivot?->created_at;
            $etat_commande = $vente?->pivot->vc_etat;
            $is_remplacer = $retour?->re_id && $retour?->etat > 0;
            $is_remplacant = $retourner?->re_id && $retourner?->etat > 0;

            if ($is_remplacant) $sorties['is_rep'] = 1;

            switch ($etat_commande) {
                    // la commande est en cours
                case 0:
                    $sorties['action'] = [];
                    break;
                    // la commande est valider
                case 1:
                    $sorties['action'] = ['E', 'R'];
                    break;
                    // la commande est rendu ou refuser
                case 2:
                    $sorties['action'] = ['V', 'E'];
                    break;
                    // la commande est echanger => reste a savoir le type
                case 3:
                    if ($is_remplacer && $is_remplacant) { // voir le dernier act
                        if ($retour->created_at > $retourner->created_at) $sorties['action'] = ['V', 'E']; // test
                        else $sorties['action'] = []; // test
                    } else if ($is_remplacer) $sorties['action'] = ['V', 'E']; // i1+1 par defaut dans boutique // test
                    else if ($is_remplacant) $sorties['action'] = []; // i2-1
                    else $sorties['action'] = []; // test
                    break;
            }

            $sorties['etat'] = $etat_commande ?? (array_key_exists('is_rep', $sorties) ? -100 : -200);
            return $sorties;
        }

        // cas ou l'iphone est introuvable
        return [
            'modele' => [],
            'action' => [],
            'etat' => null,
        ];
    }

    public static function iphoneUpdate(Iphone | null $iphone, string $action)
    {
        if (isset($iphone) && $iphone->i_id) {
            switch ($action) {
                    // Rendre | Refuser
                case 'R':
                    DB::transaction(function () use ($iphone) {
                        $iphone->modele->increment('m_qte');
                        $iphone->paiements()->delete();
                    });
                    break;

                    // Echanger E-1 : Donner aux fournisseurs
                    // case 'E-1':
                    //     DB::transaction(function () use ($iphone) {
                    //         $iphone->modele->decrement('m_qte');
                    //         $iphone->paiements()->delete();
                    //     });
                    //     break;

                    // Echanger E+1 : Rester dans la boutique
                case 'E+1':
                    $iphone->modele->increment('m_qte');
                    break;

                    // Remplacant sort dans la boutique
                case 'V':
                    $iphone->modele->decrement('m_qte');
                    break;
                    // Remplacant reste dans la boutique
                    // case 'AV':
                    //     $iphone->modele->increment('m_qte');
                    //     break;
            }
        }
    }

    // ! Affiche l'etat exacte de l'iphone sur l'ensemble des mouvements
    public static function etat(Iphone | null $iphone)
    {
        $get_etat = self::iphoneEtat($iphone)['etat'];
        // code experience +1
        if ($get_etat === -100) return "iPhone remplacant";
        if ($get_etat === -200) return "iPhone pas vendus";
        return ($get_etat == 0 ? 'en cours' : ($get_etat == 1 ? 'valider'  : ($get_etat == 2 ? 'rendu' : ($get_etat == 3 ? 'echanger' : 'Vide'))));
    }

    // ! fix major bugs : C'etait le seul moyen pour corriger le bugs majeure qui disait que les meme commandes sont la dernierer
    // Utiliser au niveaux du calcul de paiement VendreHelper
    // Utiliser au niveaux de l'affichage des commandes vendre.show
    public static function etat_fixe(Iphone | null $iphone)
    {
        $get_etat = $iphone->pivot->vc_etat;
        return ($get_etat == 0 ? 'en cours' : ($get_etat == 1 ? 'valider'  : ($get_etat == 2 ? 'rendu' : ($get_etat == 3 ? 'echanger' : '')))); // code experience +1
    }

    public static function findIphoneByBarcode($barcode, $en_id)
    {
        return Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->where('i_barcode', '=', $barcode)->first();
    }
}
