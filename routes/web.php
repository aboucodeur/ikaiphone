<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\IphoneController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendreController;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Modele;
use App\Models\Retour;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'user_type:admin,user'])->group(function () {
    // vendres
    Route::resource('vendre', VendreController::class);
    Route::post('vendre/commande/{vendre}', [VendreController::class, 'addCommande'])->name('vendre.addCommande');
    Route::put('vendre/commande/{vendre}/validate', [VendreController::class, 'editCommande'])->name('vendre.editCommande');
    Route::put('vendre/commande/{vendre}/edit', [VendreController::class, 'validCommande'])->name('vendre.validCommande');
    Route::delete('vendre/commande/{vendre}', [VendreController::class, 'remCommande'])->name('vendre.remCommande');
    // paiement de la vente
    Route::get('vendre/{vendre}/paiement/{iphone}', [VendreController::class, 'paiementPage'])->name('vendre.paiement.index');
    Route::post('vendre/{vendre}/paiement', [VendreController::class, 'addPaiement'])->name('vendre.paiement.create');
    Route::put('vendre/{vpaiement}/paiement', [VendreController::class, 'validPaiement'])->name('vendre.paiement.valid');
    Route::delete('vendre/{vpaiement}/paiement', [VendreController::class, 'remPaiement'])->name('vendre.paiement.destroy');

    // retours
    Route::resource('retour', RetourController::class);
    Route::put('retour/{retour}/valid', [RetourController::class, 'validRetour']);
    Route::resource('client', ClientController::class);
});

Route::middleware(['auth', 'user_type:admin'])->group(function () {
    // Tableaux de bords de l'application
    Route::get('/', function () {
        // etats de la ventes mensuels
        $ventes = DB::table('vcommandes AS v')
            ->select(
                'm.m_nom',
                'c.c_nom',
                DB::raw('SUM(COALESCE(vp.montant, 0)) AS montant'),
                DB::raw('v.vc_prix - SUM(COALESCE(vp.montant, 0)) AS reste'),
                DB::raw('MAX(vp.vp_date) AS dernier_paiement'), // Utilisation de la colonne vp_date pour la date du dernier paiement
                DB::raw("TO_CHAR(v.created_at, 'YYYY-MM') AS mois_courant") // Formater la date en année-mois
            )
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, MAX(vp_date) AS vp_date, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'v.i_id', '=', 'vp.i_id')
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->join('iphones AS i', 'v.i_id', '=', 'i.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->whereYear('v.created_at', now()->year)
            ->whereMonth('v.created_at', now()->month)
            ->groupBy('m.m_nom', 'c.c_nom', 'v.vc_prix', 'mois_courant')
            ->get();


        $stocks = (int) Modele::sum('m_qte');
        $clients = Client::count();
        $frs = Fournisseur::count();
        $rets = Retour::count();

        return view('dashboard', compact('stocks', 'clients', 'frs', 'rets', 'ventes'));
    })->name('home');

    Route::get('/stats/pdf', function () {
        // etats de la ventes mensuels
        $ventes = DB::table('vcommandes AS v')
            ->select(
                'm.m_nom',
                'c.c_nom',
                'm.m_type',
                'm.m_couleur',
                'm.m_memoire',
                'i.i_barcode',
                DB::raw('SUM(COALESCE(vp.montant, 0)) AS montant'),
                DB::raw('v.vc_prix - SUM(COALESCE(vp.montant, 0)) AS reste'),
                DB::raw('MAX(vp.vp_date) AS dernier_paiement'), // Utilisation de la colonne vp_date pour la date du dernier paiement
                DB::raw("TO_CHAR(v.created_at, 'YYYY-MM') AS mois_courant") // Formater la date en année-mois
            )
            ->leftJoin(DB::raw('(SELECT SUM(COALESCE(vp_montant, 0)) AS montant, MAX(vp_date) AS vp_date, i_id FROM vpaiements GROUP BY i_id) AS vp'), 'v.i_id', '=', 'vp.i_id')
            ->join('vendres', 'v.v_id', '=', 'vendres.v_id')
            ->join('clients AS c', 'vendres.c_id', '=', 'c.c_id')
            ->join('iphones AS i', 'v.i_id', '=', 'i.i_id')
            ->join('modeles AS m', 'i.m_id', '=', 'm.m_id')
            ->whereYear('v.created_at', now()->year)
            ->whereMonth('v.created_at', now()->month)
            ->groupBy('m.m_nom', 'c.c_nom', 'v.vc_prix', 'mois_courant', 'm.m_type', 'm.m_couleur', 'm.m_memoire', 'i.i_barcode')
            ->get();

        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $pdf->setOptions($options);

        $view = View::make('pdfventes', compact('ventes'))->render();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4');
        $pdf->render();

        $filename = "Etats_ventes_" . now() . ".pdf";
        return $pdf->stream($filename, array("Attachment" => false));
    })->name('pdfventes');

    // ** Resource
    Route::resource('modele', ModeleController::class);
    Route::resource('iphone', IphoneController::class);
    Route::resource('fournisseur', FournisseurController::class);
    // ** Route avances
    // achats
    Route::resource('achat', AchatController::class);
    Route::post('achat/commande/{achat}', [AchatController::class, 'addCommande'])->name('achat.addCommande');
    Route::put('achat/commande/{achat}/edit', [AchatController::class, 'validCommande'])->name('achat.validCommande');
    Route::delete('achat/commande/{achat}', [AchatController::class, 'remCommande'])->name('achat.remCommande');
    // gestion du compte de l'utilisateur connecter a l'application !
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // utilisateur que l'administrateur de l'application gere
    Route::resource('user', UserController::class);
});

require __DIR__ . '/auth.php';
