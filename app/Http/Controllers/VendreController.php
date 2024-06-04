<?php

namespace App\Http\Controllers;

use App\Helpers\StockHelper;
use App\Helpers\VendreHelper;
use App\Models\Client;
use App\Models\Iphone;
use App\Models\Retour;
use App\Models\Vendre;
use App\Models\Vpaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendreController extends Controller
{
    // OK
    public function index()
    {
        $en_id = auth()->user()->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', '=', $en_id)->orderBy('c_type')->get();
        $vendres = Vendre::whereHas('client', function ($query) use ($en_id) {
            $query->where('en_id', '=', $en_id);
        })->latest('created_at')->get();
        return view('pages.vendre.index', compact('vendres', 'clients'));
    }

    // OK
    public function store(Request $request)
    {
        $datas = $request->validate([
            'v_date' => ['required', 'date'],
            'c_id' => ['required', 'exists:clients,c_id']
        ]);
        $client = Client::findOrFail($datas['c_id']);
        $v_type_dict = [
            'SIMPLE' => 'SIM',
            'REVENDEUR' => 'REV'
        ];
        $datas['v_type'] = $v_type_dict[$client->c_type];
        $datas['v_etat'] = 0;
        $v = Vendre::create($datas);
        return redirect()->route('vendre.show', $v);
    }

    // OK
    public function edit(Vendre $vendre)
    {
        $en_id = auth()->user()->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', '=', $en_id)->orderBy('c_type')->get();
        return view('pages.vendre.edit', compact('vendre', 'clients'));
    }

    // OK
    public function update(Request $request, Vendre $vendre)
    {
        $datas = $request->validate([
            'v_date' => ['required', 'date'],
            'c_id' => ['required', 'exists:clients,c_id']
        ]);
        $vendre->update($datas);
        return redirect()->route('vendre.index');
    }

    // OK
    public function destroy(Vendre $vendre)
    {
        $vendre->delete();
        return redirect()->route('vendre.index');
    }

    // OK
    public function show(Vendre $vendre)
    {
        $en_id = auth()->user()->en_id;
        $paniers = $vendre?->iphones;
        return view('pages.vendre.show', compact('vendre', 'paniers'));
    }

    /** COMMANDES */

    // OK
    public function addCommande(Request $request, Vendre $vendre)
    {
        $en_id = auth()->user()->en_id;
        $datas = $request->validate([
            'prix' => ['numeric', 'required'],
            'vbarcode' => ['required'],
        ]);

        $iphone = StockHelper::findIphoneByBarcode($datas['vbarcode'], $en_id);
        $etat_iphone = StockHelper::iphoneEtat($iphone);

        // dd($etat_iphone);

        // ne pas oublier === null
        if (($etat_iphone['etat'] === -200 && empty($etat_iphone['action']) && empty($etat_iphone['is_rep'])) || in_array('V', $etat_iphone['action'])) {
            $vendre->iphones()->attach($iphone?->i_id, [
                'vc_etat' => 0,
                'vc_qte' => 1,
                'vc_prix' => $datas['prix'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        return redirect()->route('vendre.show', $vendre);
    }

    // OK
    public function remCommande(Request $request, Vendre $vendre)
    {
        $vendre->iphones()->detach([$request->input('i_id')]);
        return redirect()->route('vendre.show', $vendre);
    }

    // OK
    public function validCommande(Vendre $vendre)
    {
        if ($vendre->v_etat < 1) {
            DB::transaction(function () use ($vendre) {
                $vendre->update(['v_etat' => 1]);
                foreach ($vendre->iphones as $iphone) {
                    $iphone->pivot->update(['vc_etat' => 1]);
                    $iphone->modele->decrement('m_qte');
                }
            });
        }
        return redirect()->route('vendre.show', $vendre);
    }

    // OK
    public function editCommande(Request $request, Vendre $vendre)
    {
        $datas = $request->validate([
            'type' => ['required'],
            'i_id' => ['required', 'exists:iphones,i_id']
        ]);

        $iphone = $vendre->iphones()->findOrFail($datas['i_id']);
        $type = $datas['type'];
        $etat_vente = $vendre->v_etat;
        $etat_iphone = StockHelper::iphoneEtat($iphone);

        // si la vente est valider
        if ($etat_vente > 0) {
            switch ($type) {
                case 'R':
                    if (in_array('R', $etat_iphone['action'])) {
                        $iphone->pivot->update(['vc_etat' => 2]);
                        StockHelper::iphoneUpdate($iphone, 'R');
                    }
                    break;
                case 'E':
                    // etat du premier iphone
                    if (in_array('E', $etat_iphone['action'])) {
                        $en_id = auth()->user()->en_id;
                        $ip_ech_id = $request->ip_ech_id;
                        $ip_ech_desc = $request->ip_ech_desc ?? 'Pas connus';

                        $ip_remp = $ip_ech_id ? StockHelper::findIphoneByBarcode($ip_ech_id, $en_id) : null;

                        if ($ip_remp && $iphone->i_barcode !== $ip_remp->i_barcode) { // pas le meme code bare
                            $etat_ip_remp = StockHelper::iphoneEtat($ip_remp);
                            // cas ou l'on peut echanger l'iphone
                            // ne pas oublier null
                            if (($etat_ip_remp['etat'] === -200 && empty($etat_ip_remp['action'])) || in_array('E', $etat_ip_remp['action'])) {
                                // dd("Oui c'est un arrivage on peut remplacer");
                                // creation du retour et mettre a jour l'etat du commande
                                DB::transaction(function () use ($iphone, $ip_remp, $en_id, $ip_ech_desc) {
                                    $iphone->pivot->update(['vc_etat' => 3]);
                                    Retour::create([
                                        're_date' => now(),
                                        're_motif' => $ip_ech_desc,
                                        'i_id' => $iphone->i_id,
                                        'i_ech_id' => $ip_remp->i_id,
                                        'en_id' => $en_id
                                    ]);
                                });
                            }
                        }
                    }
                    break;
            }
        }

        return redirect()->route('vendre.show', $vendre);
    }

    /** PAIEMENTS */
    public function paiementPage(Vendre $vendre, Iphone $iphone)
    {
        // $commandes = $vendre->iphones;
        $paiements = $vendre->paiements()->where('i_id', '=', $iphone->i_id)->get();
        return view('pages.vendre.paiement', compact('vendre', 'iphone', 'paiements'));
    }

    // OK
    public function addPaiement(Request $request, Vendre $vendre)
    {
        $v_id = $vendre->v_id;
        $datas = $request->validate([
            'vp_motif' => ['required'],
            'vp_montant' => ['numeric', 'required'],
            'i_id' => ['required', 'exists:iphones,i_id']
        ]);

        $p = VendreHelper::paiementCommande($vendre->iphones()->findOrFail($datas['i_id']));
        if ($datas['vp_montant'] <= $p['creste']) {
            $datas['v_id'] = $v_id;
            $datas['vp_date'] = now();
            Vpaiement::create($datas);
        }
        return redirect()->route('vendre.show', $vendre);
    }

    public function validPaiement(Vpaiement $vpaiement)
    {
        $vpaiement->update(['vp_etat' => 1]);
        return redirect()->back();
    }

    public function remPaiement(Vpaiement $vpaiement)
    {
        $vpaiement->delete();
        return redirect()->back();
    }

    // OK
    public function checkIphone(Request $request)
    {
        $html = '';
        $en_id = auth()->user()->en_id;
        $iphone = StockHelper::findIphoneByBarcode($request->vbarcode, $en_id);

        if (!$iphone) $html = '<p>Cet iPhone n\'existe pas dans la boutique !</p>';
        else {
            $etat_iphone = StockHelper::etat($iphone);
            $html = "
                <p class='m-0'>" . $iphone->modele->m_nom . " " . $iphone->modele->m_type . "(" . $iphone->modele->m_memoire . ") GO</p>
                <p class='m-0'>En stock : " . (int)$iphone->modele->m_qte . "</p>
                <p class='m-0'>Etat de l'iphone : " . $etat_iphone . "</p>
                <p class='m-0'>Prix base : " . number_format($iphone->modele->m_prix, 0, '.', ' ') . " F</p>

            ";
        }
        return response($html, 200)->header('Content-Type', 'text/html');
    }
}
