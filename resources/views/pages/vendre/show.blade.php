@extends('includes.wrapper.panier')

@section('fpanier')
    @if ($vendre->v_etat < 1)
        <x-fpanier route="{{ route('vendre.addCommande', $vendre) }}" />
    @endif
@endsection

@section('panier')
    <x-panier>
        @foreach ($paniers as $iphone)
            @php
                $cpaiement = App\Helpers\VendreHelper::paiementCommande($iphone);
            @endphp
            <tr>
                <td class="w-25">
                    <strong style="text-transform: uppercase" class="text-primary">
                        {{ $iphone->modele->m_nom }}
                        {{ $iphone->modele->m_type }} /
                        {{ $iphone->modele->m_memoire }} (GO)
                        {{ $iphone->i_barcode }}
                    </strong>
                </td>
                <td class="w-1">
                    <strong>
                        {{ \App\Helpers\StockHelper::etat_fixe($iphone) }}
                    </strong>
                </td>
                <td>
                    @if ((int) $cpaiement['cmontant'] === 0)
                        <span>-/-</span>
                    @else
                        {{ number_format(((int) $cpaiement['cmontant']), 0, '', ' ') }}
                        <sub>F</sub>
                    @endif
                </td>
                <td>
                    <div>
                        @if ($vendre->v_etat > 0)
                            <div class="d-flex w-100 align-items-center flex-wrap gap-1">
                                {{-- Afficher le bouton de paiement si l'etat est a 1 --}}
                                @if (\App\Helpers\StockHelper::etat_fixe($iphone) === 'valider')
                                    <a title="Payer" role="button"
                                        href="{{ route('vendre.paiement.index', [$vendre, $iphone]) }}"
                                        class="btn btn-sm btn-success" role="button">
                                        PAIE
                                        <i class="bi bi-cash-stack"></i>
                                    </a>
                                @endif

                                {{-- @if ($vendre->v_type === 'REV') --}}
                                @if ($iphone->pivot->vc_etat < 2)
                                    <form method="POST" action="{{ route('vendre.editCommande', $iphone->pivot->v_id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                                        <input type="hidden" name="type" value="R">
                                        <button title="Rendre" type="submit" class="btn btn-sm btn-primary">
                                            RENDRE &nbsp; <i class="bi bi-box-arrow-left"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Verifcation ici : si --}}
                                @if ($iphone->pivot->vc_etat < 3 && \App\Helpers\StockHelper::iphoneEtat($iphone)['is_latest'])
                                    {{ \App\Helpers\ModalHelper::action(
                                        'addEchange',
                                        'ECHANGER &nbsp;<img width="13px" src="/assets/images/svg/arrow-down-up.svg" alt="Arrow down up icon">',
                                        [
                                            'route' => route('vendre.editCommande', $iphone->pivot->v_id),
                                            'i_id' => $iphone->i_id,
                                            'type' => 'E',
                                        ],
                                        'btn btn-sm btn-warning',
                                    ) }}
                                @endif
                                {{-- @endif --}}

                            </div>
                        @endif
                    </div>

                    {{-- Retirer si la vente est en cours --}}
                    @if ($vendre->v_etat < 1)
                        <form method="POST" action="{{ route('vendre.remCommande', $iphone->pivot->v_id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                            <button type="submit" class="btn btn-sm">
                                Retirer <i class="text-danger" data-feather="trash"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-panier>
@endsection

@section('ipanier')
    @php
        $show_state = $vendre->v_etat < 1 ? 'true' : 'false';
        $paiement = App\Helpers\VendreHelper::paiementVendre($vendre);
    @endphp

    <x-ipanier route="{{ route('vendre.validCommande', $vendre) }}" show="{{ $show_state }}"
        client="{{ $vendre->client->c_nom }}" type="{{ App\Helpers\VendreHelper::typeVente($vendre) }}"
        etat="{{ App\Helpers\VendreHelper::etatVente($vendre) }}" mte="{{ $paiement['montant'] }}"
        reste="{{ $paiement['reste'] }}" />
@endsection
