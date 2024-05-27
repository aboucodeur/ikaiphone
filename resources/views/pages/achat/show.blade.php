@extends('includes.wrapper.panier', ['run_script' => '1'])

@section('fpanier')
    @if ($achat->a_etat < 1)
        <x-afpanier route="{{ route('achat.addCommande', $achat) }}" :modeles="[...$modeles]" />
    @endif
@endsection

@section('panier')
    <x-panier>
        @foreach ($paniers as $iphone)
            <tr>
                <td class="w-30">
                    <strong>
                        {{ $iphone->i_barcode }}
                    </strong>
                    /
                    {{ $iphone->modele->m_nom . ' ' . $iphone->modele->m_type . ' ' . $iphone->modele->m_memoire . ' (GO)' }}
                </td>
                <td class="w-5">
                    @if ($achat->a_etat < 1)
                        <span>En cours</span>
                    @else
                        <img src="/assets/images/svg/check.svg" />
                    @endif
                </td>
                <td>
                    {{ number_format($iphone->pivot->ac_prix, 0, '', ' ') }}
                    <sub>F</sub>
                </td>
                <td class="">
                    @if ($achat->a_etat < 1)
                        <form method="POST" action="{{ route('achat.remCommande', $iphone->pivot->a_id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="i_id" value="{{ $iphone->i_id }}">
                            <button type="submit" class="btn btn-sm">
                                <i class="text-danger" data-feather="trash"></i>
                            </button>
                        </form>
                    @else
                        {{ ' Valider ' }}
                    @endif
                </td>
            </tr>
        @endforeach
    </x-panier>
@endsection

@section('ipanier')
    @php
        $show_state = $achat->a_etat < 1 ? 'true' : 'false';
        $paiement = App\Helpers\AchatHelper::paiementAchat($achat);
    @endphp
    <x-ipanier route="{{ route('achat.validCommande', $achat) }}" is_achat='1' show="{{ $show_state }}"
        etat="{{ App\Helpers\AchatHelper::etatAchat($achat) }}" client="{{ $achat->fournisseur->f_nom }}"
        mte="{{ $paiement[0] }}" />
@endsection
