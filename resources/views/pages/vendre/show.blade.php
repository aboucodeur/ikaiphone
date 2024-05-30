@extends('includes.wrapper.panier')

@section('fpanier')
    @if ($vendre->v_etat < 1)
        <x-fpanier route="{{ route('vendre.addCommande', $vendre) }}" :iphones="[...$iphones]" />
    @endif
@endsection

@section('panier')
    <x-panier>
        @foreach ($paniers as $iphone)
            @php
                $cpaiement = App\Helpers\VendreHelper::paiementCommande($iphone);
                $etat_cmd = App\Helpers\VendreHelper::etatCommande($vendre, $iphone);
            @endphp
            <tr>
                <td class="w-30">
                    <strong style="text-transform: uppercase" class="text-primary">
                        {{ $iphone->modele->m_nom }}
                        {{ $iphone->modele->m_type }} /
                        {{ $iphone->modele->m_memoire }} (GO)
                        {{ $iphone->i_barcode }}
                    </strong>
                </td>
                <td class="w-5 {{ $etat_cmd == 'rendu' ? 'text-danger' : '' }}">
                    <strong>{{ $etat_cmd }}</strong>
                </td>
                <td>
                    {{ number_format(((int) $cpaiement['cmontant']), 0, '', ' ') }}
                    <sub>F</sub>
                    / R :
                    {{ number_format((int) $cpaiement['creste'], 0, '', ' ') }}
                    <sub>F</sub>
                </td>
                <td class="">
                    <div class="col-lg-12">
                        @if ($vendre->v_etat > 0)
                            <div class="d-flex flex-wrap gap-1">
                                <a title="Payer" role="button"
                                    href="{{ route('vendre.paiement.index', [$vendre, $iphone]) }}"
                                    class="btn btn-sm btn-success" role="button">
                                    @if ($cpaiement['creste'] == 0)
                                        Voir
                                    @endif
                                    <i class="bi bi-cash-stack"></i>
                                </a>

                                @if ($vendre->v_type === 'REV')
                                    <form method="POST" action="{{ route('vendre.editCommande', $iphone->pivot->v_id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                                        <input type="hidden" name="type" value="vendu">
                                        <button title="Vendu" type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-box-arrow-right"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('vendre.editCommande', $iphone->pivot->v_id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                                        <input type="hidden" name="type" value="rendu">
                                        <button title="Rendu" type="submit" class="btn btn-sm btn-warning">
                                            <i class="bi bi-box-arrow-left"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        @endif
                    </div>
                    @if ($vendre->v_etat < 1)
                        <form method="POST" action="{{ route('vendre.remCommande', $iphone->pivot->v_id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                            <button type="submit" class="btn btn-sm">
                                <i class="text-danger" data-feather="trash"></i>
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
