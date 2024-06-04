<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{

    // ! Fix Bugs : Request unecessary sql code aggregate functions
    public function index(Request $request)
    {

        $get_pay =  $request->get('pay');
        $is_pay = $get_pay == "p";
        $is_not_pay = $get_pay == "np";
        $is_all_pay = !isset($get_pay) || $get_pay == "all";

        // adapter pour que la requete soit adapté au niveau de l'entreprise
        $en_id = auth()->user()->en_id;
        $etats_pay_ventes = DB::table('vcommandes AS v')
            ->select(
                'm.m_nom',
                'c.c_nom',
                'vendres.v_id',
                'i.i_id',
                'montant',
                DB::raw('v.vc_prix - COALESCE(montant,0)  AS reste'),
                DB::raw("CASE WHEN v.vc_prix - COALESCE(montant,0) = 0 THEN 'Payé' ELSE 'Non payé' END AS etat_paiement"),
                DB::raw("TO_CHAR(v.created_at, 'YYYY-MM') AS mois_courant")
            )
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('iphones AS i', 'v.i_id', '=', 'i.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'v.i_id', '=', 'vp.i_id')
            ->where('c.en_id', '=', $en_id)
            ->where('v.vc_etat', '=', 1) // seulement les ventes valider
            ->whereRaw(
                $is_pay
                    ? '(v.vc_prix - COALESCE(montant, 0)) = 0 and vc_etat = 1'
                    : ($is_not_pay
                        ? '(v.vc_prix - COALESCE(montant, 0)) > 0 and vc_etat = 1'
                        : '(v.vc_prix - COALESCE(montant, 0)) > 0 or (v.vc_prix - COALESCE(montant, 0)) = 0 and vc_etat = 1')
            )

            ->orderBy('etat_paiement', 'asc')
            ->get();
        return view('pages.paiement.index', compact('etats_pay_ventes'));
    }
}
