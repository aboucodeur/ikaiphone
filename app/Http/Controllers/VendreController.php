<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $en_id = auth()->user()->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', '=', $en_id)->orderBy('c_type')->get();
        $vendres = Vendre::with(['client'])->whereHas('client', function ($query) use ($en_id) {
            $query->where('en_id', '=', $en_id);
        })->get();
        return view('pages.vendre.index', compact('vendres', 'clients'));
    }

    public function create()
    {
        $en_id = auth()->user()->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', '=', $en_id)->orderBy('c_type')->get();
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
        $en_id = auth()->user()->en_id;
        $clients = Client::query()->latest('created_at')->where('en_id', '=', $en_id)->orderBy('c_type')->get();
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

    // ! fix : Affiche les iphones de l'entreprise donnee !
    public function show(Vendre $vendre)
    {
        $en_id = auth()->user()->en_id;
        $paniers = $vendre?->iphones;

        $ids = $vendre->iphones()->pluck('iphones.i_id');
        $vids = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->withCount('ventes')->get()->where('ventes_count', '>', 0)->pluck('i_id');
        $rids = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->withCount('retour')->get()->where('retour_count', '>', 0)->pluck('i_ech_id');
        $dont_show = [...$ids, ...$vids, ...$rids]; // ids des iphones non disponibles

        $iphones = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->latest('created_at')->whereNotIn('iphones.i_id', [...$dont_show])->get(); // iphones disponibles

        return view('pages.vendre.show', compact('vendre', 'iphones', 'paniers'));
    }

    // TODO : Verification de l'iphone lors de la vente
    public function checkIphone(Request $request)
    {
        $en_id = auth()->user()->en_id;
        $iphone = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->where('i_barcode', '=', $request->vbarcode)->first();

        $retour = $iphone?->retour;
        $ventes = $iphone?->ventes;

        $html = "
            <p class='m-0'>" . $iphone->modele->m_nom . " " . $iphone->modele->m_type . "(" . $iphone->modele->m_memoire . ") GO</p>
            <p class='m-0'>En stock : " . (int)$iphone->modele->m_qte . "</p>
            <p class='m-0'>Prix base : " . number_format($iphone->modele->m_prix, 0, '.', ' ') . " F</p>
        ";

        // si retourner pour : i_id
        if ($retour) {
            $html = '<p class="text-danger mt-3">Iphone Deja retourner</p>';
            return response($html, 200)->header('Content-Type', 'text/html');
        }

        // si retour pour i_ech_id
        $has_retour = Retour::query()->where('i_ech_id', '=', $iphone?->i_id)->where('en_id', '=', $en_id)->first();
        if ($has_retour) $html = '<p class="text-danger mt-3">Cet iphone a remplacer une autres</p>';

        // si vendu
        if ($ventes?->count() > 0) {
            $etat_commande = $ventes[0]->pivot->vc_etat;
            if ($etat_commande > 0) $html = '<p class="text-danger mt-3">Iphone Deja vendu</p>';
            else {
                $html = '
                <form class="mt-3" method="POST" action="' . route('vendre.remCommande', $ventes[0]->pivot->v_id) . '">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="i_id" value="' . $iphone->i_id . '">
                <button type="submit" class="btn btn-sm btn-primary">
                    <img src="/assets/images/svg/refresh-ccw.svg" alt="refresh">
                    Annuler la commande !
                </button>
            </form>
                ';
            }
            return response($html, 200)->header('Content-Type', 'text/html');
        }

        return response($html, 200)->header('Content-Type', 'text/html');
    }

    /** COMMANDES */

    // ! fix : AJOUTER UNE COMMANDE DE VENTE A LA VENTE !
    public function addCommande(Request $request, Vendre $vendre)
    {
        $en_id = auth()->user()->en_id;
        $datas = $request->validate([
            'prix' => ['numeric', 'required'],
            'vbarcode' => ['required'],
            // 'color' => ['required']
        ]);

        $iphone = Iphone::whereHas('modele', function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        })->where('i_barcode', '=', $datas['vbarcode'])->first();
        $vendre->iphones()->attach($iphone->i_id, [
            'vc_etat' => 0,
            'vc_qte' => 1,
            'vc_prix' => $datas['prix'],
            // 'vc_color' => $datas['color'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back();
    }

    public function remCommande(Request $request, Vendre $vendre)
    {
        $vendre->iphones()->detach([$request->input('i_id')]);
        return redirect()->back();
    }

    public function validCommande(Vendre $vendre)
    {
        $type_vente = $vendre->v_type;
        $is_simple = $type_vente === 'SIM';

        if ($vendre->v_etat < 1) {
            // SIM & REV
            $vendre->update(['v_etat' => 1]);
            foreach ($vendre->iphones as $iphone) {
                // Transaction pour la mise a jour
                DB::transaction(function () use ($iphone, $is_simple) {
                    $iphone->pivot->update(['vc_etat' => 1]);
                    if ($is_simple) $iphone->modele->update(['m_qte' => DB::raw('m_qte - 1')]);
                });
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

    /** PAIEMENTS */
    public function paiementPage(Vendre $vendre, Iphone $iphone)
    {
        $commandes = $vendre->iphones;
        $paiements = $vendre->paiements()->where('i_id', '=', $iphone->i_id)->get();
        return view('pages.vendre.paiement', compact('vendre', 'iphone', 'paiements'));
    }

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
            return redirect()->back();
        }
        return redirect()->back();
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
}
