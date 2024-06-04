<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Fournisseur;
use App\Models\Iphone;
use App\Models\Modele;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModeleController extends Controller
{
    // OK
    public function index(Request $request)
    {
        // $modeles =  Modele::query()->latest('created_at')->withCount('iphones')->get();
        $en_id = Auth::user()->entreprise->en_id;
        $is_soft = $request->get('f') == "soft";
        $modeles = Modele::query()->latest('created_at')->where('en_id', $en_id)->withCount('iphones')->get();
        if ($is_soft) $modeles = Modele::onlyTrashed()->latest('created_at')->where('en_id', $en_id)->withCount('iphones')->get();

        $fournisseurs = Fournisseur::where('en_id', $en_id)->get();
        $types_iphones = [
            "Simple",
            "S",
            "S Plus",
            "C",
            "SE",
            "Plus",
            "Pro",
            "Pro Max",
            "Mini"
        ];

        return view('pages.modele.index', compact('modeles', 'types_iphones', 'fournisseurs'));
    }

    // OK
    public function store(Request $request)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'], // a verifier
            'm_memoire' => ['required', 'numeric', 'min:32'], // a verifier
            'm_prix' => ['required', 'numeric', 'min:0'], // a verifier
            'f_id' => '',
            'm_ids' => ''
        ]);
        $en_id = Auth::user()->entreprise->en_id;
        $data['m_qte'] = 0;
        $data['en_id'] = $en_id;
        // recuperer ou creer le modele
        // $modele = Modele::create($data); // recuperer le modele creer ignore : 'm_qte' => 0,
        $modele = Modele::firstOrCreate(['m_nom' => $data['m_nom'], 'm_type' => $data['m_type'], 'm_memoire' => $data['m_memoire'], 'm_prix' => $data['m_prix'], 'en_id' => $en_id]);

        $imei_raw = $data['m_ids'];
        $imei_iphones = array_unique(array_filter(preg_split('/;/', $imei_raw), function ($code) {
            return preg_match('/^[a-zA-Z0-9]+$/', trim($code));
        }));

        if (isset($data['f_id']) && $data['f_id'] != '' && count($imei_iphones) > 0) { // avec frs
            $frs = Fournisseur::findOrFail($data['f_id']);
            $achat = Achat::create(['a_date' => now(), 'f_id' => $frs->f_id, 'a_etat' => 0]);
            foreach ($imei_iphones as $imei) {
                // insertion iphone avec insertion du commande d'achat
                DB::transaction(function () use ($modele, $imei, $achat, $data) { // ajout de data
                    try {
                        $iphone = Iphone::create(['i_barcode' => trim($imei), 'm_id' => $modele->m_id]);
                        $achat->iphones()->attach($iphone->i_id, [
                            'ac_etat' => 0,
                            'ac_qte' => 1,
                            'ac_prix' => $data['m_prix'], // ajouter la possibiliter de modifier le prix !
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    } catch (\Exception $e) {
                        // eviter pour une iphone qui existe
                        return;
                    }
                });
            }
            return redirect()->route('modele.index');
        } else { // sans frs
            foreach ($imei_iphones as $imei) {
                // insertion iphone avec mise a jour du stock
                DB::transaction(function () use ($modele, $imei) {
                    try {
                        Iphone::create(['i_barcode' => trim($imei), 'm_id' => $modele->m_id]);
                        $modele->increment('m_qte');
                        // $modele->m_qte += 1;
                        // $modele->save();
                    } catch (\Exception $e) {
                        // eviter pour une iphone qui existe
                        return;
                    }
                });
            }
            return redirect()->route('modele.index');
        }
    }

    // OK
    public function edit(Modele $modele)
    {
        if ($modele->en_id != Auth::user()->entreprise->en_id) return abort(404, 'Vous n\'êtes pas autorisé à modifier ce modèle');
        return view('pages.modele.edit',  compact('modele'));
    }

    public function update(Request $request, Modele $modele)
    {
        $data = $request->validate([
            'm_nom' => ['required'],
            'm_type' => ['required'], // a verifier
            'm_memoire' => ['required', 'numeric', 'min:32'], // a verifier
            'm_prix' => ['required', 'numeric', 'min:0'], // a verifier
        ]);

        $modele->update($data);
        return redirect()->route('modele.index')->with('success', 'Modele mis à jour avec succès');
    }

    // OK
    public function destroy(Modele $modele)
    {
        if ($modele->en_id != Auth::user()->entreprise->en_id) return abort(404, 'Vous n\'êtes pas autorisé à supprimer ce modèle');
        $modele->delete();
        return redirect()->route('modele.index')->with('success', 'Modele supprimé avec succès');
    }

    public function restore($id)
    {
        $modele = Modele::withTrashed()->findOrFail($id);
        $modele->restore();
        return redirect()->route('modele.index')->with('success', 'Modele restauré avec succès');
    }
}
