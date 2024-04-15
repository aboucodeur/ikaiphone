<?php

namespace App\Http\Controllers;

use App\Helpers\VendreHelper;
use App\Models\Client;
use App\Models\Iphone;
use App\Models\Vendre;
use App\Models\Vpaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendreController extends Controller
{
    public function index()
    {
        $vendres = Vendre::query()->latest('created_at')->get();
        $clients = Client::withTrashed()->latest('created_at')->orderBy('c_type')->get();
        return view('pages.vendre.index', compact('vendres', 'clients'));
    }

    public function create()
    {
        $clients = Client::withTrashed()->latest('created_at')->orderBy('c_type')->get();
        return view('pages.vendre.create', compact('clients'));
    }

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

    public function edit(Vendre $vendre)
    {
        $clients = Client::withTrashed()->latest('created_at')->get();
        return view('pages.vendre.edit', compact('vendre', 'clients'));
    }

    public function update(Request $request, Vendre $vendre)
    {
        $datas = $request->validate([
            'v_date' => ['required', 'date'],
            'c_id' => ['required', 'exists:clients,c_id']
        ]);
        $vendre->update($datas);
        return redirect()->route('vendre.index');
    }

    public function destroy(Vendre $vendre)
    {
        $vendre->delete();
        return redirect()->route('vendre.index');
    }

    public function show(Vendre $vendre)
    {
        $paniers = $vendre?->iphones;

        $datas_iphones = []; // seulement les bonne iphones !
        $ids = $vendre->iphones()->pluck('iphones.i_id');
        $vids = Iphone::withCount('ventes')->get()->where('ventes_count', '>', 0)->pluck('i_id');
        $rids = Iphone::withCount('retour')->get()->where('retour_count', '>', 0)->pluck('i_ech_id');
        $dont_show = [...$ids, ...$vids, ...$rids];
        $iphones = Iphone::query()->latest('created_at')->whereNotIn('iphones.i_id', [...$dont_show])->get();

        foreach ($iphones as $key => $iphone) {
            if ($iphone->modele) {
                $datas_iphones[] = [
                    'id' => $iphone->i_id,
                    'barcode' => $iphone->i_barcode,
                    'modele' => $iphone->modele->m_nom,
                    'type' => $iphone->modele->m_type,
                    'memoire' => $iphone->modele->m_memoire,
                    'qte' => $iphone->modele->m_qte,
                    'prix' => $iphone->modele->m_prix,
                    'couleur' => $iphone->modele->m_couleur,
                ];
            }
        }

        return view('pages.vendre.show', compact('vendre', 'iphones', 'paniers', 'datas_iphones'));
    }

    // Ajouter la commande de vente (pivot)
    public function addCommande(Request $request, Vendre $vendre)
    {
        $datas = $request->validate([
            'prix' => ['numeric', 'required'],
            'vbarcode' => ['required']
        ]);

        $iphone = Iphone::query()->where('i_barcode', '=', $datas['vbarcode'])->first();

        // via eloquent je peux joindre les deux avec leur pivot
        $vendre->iphones()->attach($iphone->i_id, [
            'vc_etat' => 0,
            'vc_qte' => 1,
            'vc_prix' => $datas['prix'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back();
    }

    // Supprimer la commande de vente (pivot)
    public function remCommande(Request $request, Vendre $vendre)
    {
        $vendre->iphones()->detach([$request->input('i_id')]);
        return redirect()->back();
    }

    // Valider la vente
    public function validCommande(Vendre $vendre)
    {
        $type_vente = $vendre->v_type;
        $is_simple = $type_vente === 'SIM';

        if ($vendre->v_etat < 1) {
            // SIM & REV
            $vendre->update(['v_etat' => 1]);
            $iphones = $vendre->iphones;
            foreach ($iphones as $iphone) {
                $iphone->pivot->update(['vc_etat' => 1]);
                // SIM : Update the modele stock m_qte -1
                if ($is_simple) $iphone->modele->update(['m_qte' => DB::raw('m_qte - 1')]);
            }
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function editCommande(Request $request, Vendre $vendre)
    {
        $datas = $request->validate([
            'type' => ['required'],
            'i_id' => ['required', 'exists:iphones,i_id']
        ]);

        $etat_vente = $vendre->v_etat;

        $iphone = $vendre->iphones()->findOrFail($datas['i_id']);
        $type = $datas['type'];
        $cetat = $iphone->pivot->vc_etat;

        if ($etat_vente > 0) {
            // Revendeur : Vendu
            if ($type == 'vendu') {
                if ($cetat == 1) {
                    $iphone->pivot->update(['vc_etat' => 2]);
                    $iphone->modele->update(['m_qte' => DB::raw('m_qte - 1')]); // dimunie le stock
                }
            }

            // Revendeur : Rendu
            if ($type == 'rendu') {
                // valider -> rendu
                if ($cetat == 1) $iphone->pivot->update(['vc_etat' => 3]); // rien car pas vendu en amont
                // vendu -> a rendu
                if ($cetat == 2) {
                    $iphone->pivot->update(['vc_etat' => 3]);
                    $iphone->modele->update(['m_qte' => DB::raw('m_qte + 1')]); // augmente le stock car dimunier en amont
                }
            }

            return redirect()->back();
        }
    }

    /**
     *
     * PAIEMENTS DE LA VENTE
     *
     */

    // afficher les paiement de l'iphone et de la vente
    public function paiementPage(Vendre $vendre, Iphone $iphone)
    {
        $commandes = $vendre->iphones;
        $paiements = $vendre->paiements()->where('i_id', '=', $iphone->i_id)->get();
        return view('pages.vendre.paiement', compact('vendre', 'iphone', 'paiements'));
    }

    // ajouter un paiement pour la vente et l'iphone
    public function addPaiement(Request $request, Vendre $vendre)
    {
        // ! En programmation il ne faut avoir jamais peur et bien faire c'est un temps gagner deux fois

        $v_id = $vendre->v_id;
        $datas = $request->validate([
            'vp_motif' => ['required'],
            'vp_montant' => ['numeric', 'required'],
            'i_id' => ['required', 'exists:iphones,i_id']
        ]);

        // infos_de paiement de la commande
        $p = VendreHelper::paiementCommande($vendre->iphones()->findOrFail($datas['i_id']));

        if ($datas['vp_montant'] <= $p['creste']) {
            $datas['v_id'] = $v_id;
            $datas['vp_date'] = now();
            Vpaiement::create($datas);
            return redirect()->back();
        }
        return redirect()->back();
    }

    // valider un paiement pour la vente et l'iphone
    public function validPaiement(Vpaiement $vpaiement)
    {
        $vpaiement->update(['vp_etat' => 1]);
        return redirect()->back();
    }

    // supprimer un paiement pour la vente et l'iphone
    public function remPaiement(Vpaiement $vpaiement)
    {
        $vpaiement->delete();
        return redirect()->back();
    }
}
