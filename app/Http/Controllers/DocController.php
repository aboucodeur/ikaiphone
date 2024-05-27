<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

// ! Fix Bugs : Ameliorer les requetes sql en corrigeant les problemes de performances !
class DocController extends Controller
{
    // Listes des impayes des trois derniers
    public function printPayment()
    {
        $en_id = auth()->user()->en_id;
        $entreprise = auth()->user()->entreprise;

        $ventes = DB::table('vcommandes AS v')
            ->select(
                'm.m_nom',
                'm.m_type',
                'm.m_memoire',
                'c.c_nom',
                DB::raw('SUM(COALESCE(vp.montant, 0)) AS montant'),
                DB::raw('v.vc_prix - SUM(COALESCE(vp.montant, 0)) AS reste'),
                DB::raw('MAX(vp.vp_date) AS dernier_paiement'),
                DB::raw("TO_CHAR(v.created_at, 'YYYY-MM') AS mois_courant")
            )
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, MAX(vp_date) AS vp_date, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'v.i_id', '=', 'vp.i_id')
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->join('iphones AS i', 'v.i_id', '=', 'i.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->whereRaw("DATE_TRUNC('month', v.created_at) >= DATE_TRUNC('month', NOW() - INTERVAL '3 months')")
            ->where('c.en_id', '=', $en_id)
            ->groupBy('m.m_nom', 'c.c_nom', 'v.vc_prix', 'mois_courant', 'm.m_type', 'm.m_memoire')
            ->orderBy('dernier_paiement', 'asc')
            ->get();

        if ($ventes->count() < 1) return "Pas de donnees necessaires pour imprimer les paiement !";

        $pdf = new Dompdf();
        $options = new Options();

        $options->set('chroot', [
            dirname(__DIR__, 3) . "/" . "public/images"
        ]);
        $options->set('isHtml5ParserEnabled', true);
        $pdf->setOptions($options);

        $view = View::make('pages.docs.pdfpaiement', compact('ventes','entreprise'))->render();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4');
        $pdf->render();

        $filename = "Etats_ventes_" . now() . ".pdf";
        return $pdf->stream($filename, array("Attachment" => false));
    }

    // Facture du client donnees
    public function printClientPay(string $id)
    {
        $en_id = auth()->user()->en_id;
        $entreprise = auth()->user()->entreprise;

        $client = Client::findOrFail($id);
        $paiements = DB::table('clients AS c')
            ->select(
                'm.m_nom AS modele',
                'm.m_memoire',
                'm.m_type',
                'i.i_barcode',
                'v.v_id',
                'vc.vc_prix AS montant_total',
                DB::raw('montant AS montant_paye'),
                DB::raw('vc.vc_prix - montant AS montant_restant')
            )
            ->join('vendres AS v', 'c.c_id', '=', 'v.c_id')
            ->join('vcommandes AS vc', 'v.v_id', '=', 'vc.v_id')
            ->join('iphones AS i', 'vc.i_id', '=', 'i.i_id')
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'vc.i_id', '=', 'vp.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->where('c.c_id', '=', $client->c_id)
            ->where('c.en_id', '=', $en_id)
            ->groupBy('m.m_nom', 'v.v_id', 'i.i_barcode', 'm.m_memoire', 'm.m_type', 'vc.vc_prix', 'vp.montant')
            ->get();

        // dd($paiements);

        if ($paiements->count() < 1) return "Pas de donnees necessaires pour imprimer le paiement !";

        $fact_id = $paiements[0]->v_id;


        $pdf = new Dompdf();
        $options = new Options();
        $options->set('chroot', [
            dirname(__DIR__, 3) . "/" . "public/images"
        ]);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $pdf->setOptions($options);

        $view = View::make('pages.docs.clientpay', compact('paiements', 'client', 'fact_id', 'entreprise'))->render();
        $pdf->loadHtml($view);
        $pdf->setPaper('A5');
        $pdf->render();

        $filename = "facture_client_" . now() . ".pdf";
        return $pdf->stream($filename, array("Attachment" => false));
    }

    // Impression des reliquats des cliens avec l'article choisit
    public function printReliquat()
    {
        $en_id = auth()->user()->en_id;

        $reliquats_datas = DB::table('vcommandes AS v')
            ->select(
                'c.c_nom',
                'm.m_nom',
                'm.m_memoire',
                'm.m_type',
                'i.i_barcode',
                'v.vc_prix',
                DB::raw('COALESCE(vp.montant, 0) payer'),
                DB::raw('v.vc_prix - COALESCE(vp.montant, 0) AS reste_a_payer'),
                'v.created_at' // Ajout de la date de la commande
            )
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('iphones AS i', 'v.i_id', '=', 'i.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'v.i_id', '=', 'vp.i_id')
            ->whereRaw('(v.vc_prix - COALESCE(vp.montant, 0)) > 0')
            ->where('c.en_id', '=', $en_id)
            ->orderBy('v.created_at', 'desc')
            ->get();

        if ($reliquats_datas->count() < 1) return "Pas de donnees necessaires pour imprimer le reliquat !";

        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $pdf->setOptions($options);
        $view = View::make('pages.docs.reliquat', compact('reliquats_datas'))->render();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4');
        $pdf->render();

        $filename = "A VERIFIER RELIQUATS DU_" . now() . ".pdf";
        return $pdf->stream($filename, array("Attachment" => false));
    }
}
