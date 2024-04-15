@extends('includes.wrapper.panier')

@php
    $show_state = $vendre->v_etat < 1 ? 'true' : 'false';
    $info = $vendre->iphones()->findOrFail($iphone->i_id);

    $pvente = App\Helpers\VendreHelper::paiementVendre($vendre);
    // bugs corriger pour le montant payer de la commande
    $p = App\Helpers\VendreHelper::paiementCommande($info);
@endphp

@section('fpanier')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <a class="btn btn-sm btn-primary" href="{{ route('vendre.show', $vendre) }}" role="button">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>

        @if ($p['creste'] > 0)
            <div class="col-lg-12 mb-3">
                <div class="card text-start">
                    <div class="card-body">
                        <form action="{{ route('vendre.paiement.create', $vendre) }}" method="POST">
                            @csrf
                            <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <input autofocus type="text" class="form-control" name="vp_motif" id="vp_motif"
                                            placeholder="Motif" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <input type="number" class="form-control" name="vp_montant" id="vp_montant"
                                            placeholder="Montant" required value="{{ old('vp_montant', $p['creste']) }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Payer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endif

    </div>
@endsection


@section('panier')
    <div class="card">
        <div class="card-header mt-0 mb-0">
            <p class="p-0 m-0">iPhone : <strong>{{ $iphone->modele->m_nom }} ~ {{ $iphone->modele->m_memoire }}</strong>
                <sub>GO</sub>
            </p>
            <p class="p-0 m-0">Quantite du modele : {{ (int) $iphone->modele->m_qte }} </p>
            <p class="p-0 m-0 text-primary">Serie : {{ $iphone->i_barcode }} </p>
            <div class="divider">
                <span class="text-primary">Info paiement</span>
            </div>
            <p class="p-0 m-0">Vendus aux prix : {{ number_format($p['cmontant'], 0, '', ' ') }}
                <sub>F</sub>
            </p>
            <p class="p-0 m-0">Montants payer : {{ number_format($p['cpayer'], 0, '', ' ') }}
                <sub>F</sub>
            </p>
            <p class="p-0 m-0">Montants restante : {{ number_format($p['creste'], 0, '', ' ') }}
                <sub>F</sub>
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Montant</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paiements as $paiement)
                                    <tr>
                                        <td>{{ $paiement->vp_date }}</td>
                                        <td>{{ $paiement->vp_motif }}</td>
                                        <td>{{ number_format($paiement->vp_montant, 0, '', ' ') }} <sub>F</sub></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    @if ($paiement->vp_etat < 1)
                                                        <form method="POST"
                                                            action="{{ route('vendre.paiement.valid', $paiement) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-secondary" type="submit">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-success">{{ 'Valider' }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    @if ($paiement->vp_etat < 1)
                                                        <form method="POST"
                                                            action="{{ route('vendre.paiement.destroy', $paiement) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger" type="submit">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ipanier')
    <x-ipanier route="{{ route('vendre.validCommande', $vendre) }}" show="{{ $show_state }}"
        client="{{ $vendre->client->c_nom }}" type="{{ App\Helpers\VendreHelper::typeVente($vendre) }}"
        etat="{{ App\Helpers\VendreHelper::etatVente($vendre) }}" mte="{{ $pvente['montant'] }}"
        reste="{{ $pvente['reste'] }}" />
@endsection
