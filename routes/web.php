<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\IphoneController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendreController;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Modele;
use App\Models\Retour;
use App\Models\Vendre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_type:admin,user'])->group(function () {
    // vendres
    Route::resource('vendre', VendreController::class);
    Route::post('vendre/commande/{vendre}', [VendreController::class, 'addCommande'])->name('vendre.addCommande');
    Route::put('vendre/commande/{vendre}/validate', [VendreController::class, 'editCommande'])->name('vendre.editCommande');
    Route::put('vendre/commande/{vendre}/edit', [VendreController::class, 'validCommande'])->name('vendre.validCommande');
    Route::delete('vendre/commande/{vendre}', [VendreController::class, 'remCommande'])->name('vendre.remCommande');
    Route::post('vendre/client/', [ClientController::class, 'storeFast'])->name('vendre.client.fast');
    // ! fix : Prevent show get request
    Route::get('vendre/check/iphone', [VendreController::class, 'checkIphone'])->name('vendre.checkIphone');

    // paiement de la vente
    Route::get('vendre/{vendre}/paiement/{iphone}', [VendreController::class, 'paiementPage'])->name('vendre.paiement.index');
    Route::post('vendre/{vendre}/paiement', [VendreController::class, 'addPaiement'])->name('vendre.paiement.create');
    Route::put('vendre/{vpaiement}/paiement', [VendreController::class, 'validPaiement'])->name('vendre.paiement.valid');
    Route::delete('vendre/{vpaiement}/paiement', [VendreController::class, 'remPaiement'])->name('vendre.paiement.destroy');
    // retours
    Route::resource('retour', RetourController::class, ['except' => ['create', 'show']]);
    Route::put('retour/{retour}/valid', [RetourController::class, 'validRetour'])->name('retour.valid');
    Route::get('retour/check-iphone', [RetourController::class, 'checkIphone'])->name('retour.checkIphone');
    Route::resource('client', ClientController::class, ['except' => ['edit', 'create']]);
    // liste des paiements
    Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement.index');
});

Route::middleware(['auth', 'user_type:admin'])->group(function () {
    // ** DASHBOARD
    Route::get('/', function () {
        $en_id = auth()->user()->en_id; // identifiant de l'entreprise de l'utilisateur

        // Affiche le nombres d'impayes par clients
        $clients_commandes = DB::table('clients AS c')
            ->select(
                'c.c_nom',
                'c.c_id',
                DB::raw('COUNT(CASE WHEN (vc.vc_prix - COALESCE(vp.montant, 0)) > 0 THEN 1 END) AS nombre_dettes')
            )
            ->join('vendres AS v', 'c.c_id', '=', 'v.c_id')
            ->join('vcommandes AS vc', 'v.v_id', '=', 'vc.v_id')
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'vc.i_id', '=', 'vp.i_id')
            ->whereRaw('(vc.vc_prix - COALESCE(vp.montant, 0)) > 0 and c.en_id = :en_id', ['en_id' => $en_id]) // les clients qui trop d'impayer
            ->groupBy('c.c_nom', 'c.c_id')
            ->orderBy('nombre_dettes', 'desc')
            ->get();

        // Etats des sorties et paiements des trois derniers mois
        $etats_pay_ventes = DB::table('vcommandes AS v')
            ->select(
                'm.m_nom',
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
            ->whereRaw("DATE_TRUNC('month', v.created_at) >= DATE_TRUNC('month', NOW() - INTERVAL '3 months')") // Filtrer sur les trois derniers mois
            ->where('c.en_id', $en_id)
            ->groupBy('m.m_nom', 'c.c_nom', 'v.vc_prix', 'mois_courant')
            ->orderBy('dernier_paiement', 'asc')
            ->get();

        // Les top 10 modeles d'iphone le plus vendus
        $ventes_per_iphones = DB::table('vcommandes')
            ->select('m_nom', DB::raw('COUNT(*) as total_ventes'))
            ->join('iphones', 'vcommandes.i_id', '=', 'iphones.i_id')
            ->join('modeles', 'iphones.m_id', '=', 'modeles.m_id')
            ->where('modeles.en_id', '=', $en_id)
            ->groupBy('m_nom')
            ->orderByDesc('total_ventes')
            ->limit(10)
            ->get()->toArray();

        // Les top 10 clients qui achete le plus
        $ventes_per_clients = DB::table('vendres')
            ->select('c_nom', DB::raw('COUNT(*) as nb_ventes'))
            ->join('clients', 'vendres.c_id', '=', 'clients.c_id')
            ->join('vcommandes', 'vendres.v_id', '=', 'vcommandes.v_id')
            ->where('clients.en_id', '=', $en_id)
            ->groupBy('c_nom')
            ->orderByDesc('nb_ventes')
            ->limit(10)
            ->get()->toArray();

        // Recette du jours
        $recette_jours =  DB::table('vcommandes AS v')
            ->select(
                'c.c_nom AS client',
                DB::raw('SUM(COALESCE(vp.montant, 0)) AS montant_payer')
            )
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, v_id FROM vpaiements GROUP BY v_id) AS vp'), 'v.v_id', '=', 'vp.v_id')
            ->whereDate('v.created_at', '=', 'now()') // Filtrer par date du jour
            ->where('c.en_id', '=', $en_id)
            ->groupBy('c.c_nom')
            ->get();
        $somme_recette = $recette_jours->sum('montant_payer');

        // ajouter la condition en_id
        $stocks = (int) Modele::where('en_id', '=', $en_id)->sum('m_qte');
        $clients = Client::where('en_id', '=', $en_id)->count();
        $frs = Fournisseur::where('en_id', '=', $en_id)->count();
        $rets = Retour::where('en_id', '=', $en_id)->count();
        $ventes = Vendre::with(['client' => function ($query) use ($en_id) {
            $query->where('en_id', $en_id);
        }])->count();

        // dd($ventes);

        return view(
            'dashboard',
            compact(
                'stocks',
                'clients',
                'frs',
                'rets',
                'ventes',
                'etats_pay_ventes',
                'ventes_per_iphones',
                'ventes_per_clients',
                'clients_commandes',
                'recette_jours',
                'somme_recette'
            )
        );
    })->name('home');

    // ** Impression des documents
    Route::prefix('/docs')->group(function () {
        Route::get('/paiements', [DocController::class, 'printPayment'])->name('pdf.all.pay');
        Route::get('/client/{id}', [DocController::class, 'printClientPay'])->name('pdf.client.pay');
        Route::get('/reliquats', [DocController::class, 'printReliquat'])->name('pdf.reliquat.pay');
    });

    // ** Resource
    Route::resource('modele', ModeleController::class);
    Route::put('modele/restore/{id}', [ModeleController::class, 'restore'])->name('modele.restore');
    Route::resource('iphone', IphoneController::class, ['except' => ['create', 'edit', 'show']]);
    Route::put('iphone/restore/{id}', [IphoneController::class, 'restore'])->name('iphone.restore');

    Route::resource('fournisseur', FournisseurController::class, ['except' => ['edit', 'create', 'show']]);

    // ** Achats
    Route::resource('achat', AchatController::class);
    Route::post('achat/commande/{achat}', [AchatController::class, 'addCommande'])->name('achat.addCommande');
    Route::put('achat/commande/{achat}/edit', [AchatController::class, 'validCommande'])->name('achat.validCommande');
    Route::delete('achat/commande/{achat}', [AchatController::class, 'remCommande'])->name('achat.remCommande');

    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // user
    Route::resource('user', UserController::class, ['except' => ['create']]);
});

require __DIR__ . '/auth.php';
