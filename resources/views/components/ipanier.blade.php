@props([
    'show',
    'route' => '#',
    'client' => 'client',
    'type' => 'type',
    'etat' => 'etat',
    'mte' => 0,
    'reste' => 0,
    'is_achat',
])

<!-- Informations de la vente donc besoin de son id -->
<div class="card">
    <div class="card-header text-center">
        <i class="bi bi-info-circle-fill"></i>
        <strong>Informations de la vente</strong>
    </div>
    <div class="card-body p-0 m-0">
        <form method="POST" action="{{ $route }}">
            @csrf
            @method('PUT')
            <table class="table table-lg mb-0 mt-0 w-100">
                <tr>
                    <td> {{ isset($is_achat) ? 'Fournisseur' : 'Client / Revendeur' }}</td>
                    <td class="text-right">
                        {{ $client }}
                    </td>
                </tr>
                @if (!isset($is_achat))
                    <tr>
                        <td>Type</td>
                        <td class="text-right">
                            {{ $type }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>Etat du commande</td>
                    <td>
                        <span class="badge p-1 bg-primary">{{ $etat }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Montant total(s)</td>
                    <td>
                        <strong>
                            {{ number_format($mte, 0, '', ' ') }}
                        </strong>
                        <sub>F</sub>
                    </td>
                </tr>
                @if (!isset($is_achat))
                    <tr>
                        <td>Montant restante(s)</td>
                        <td>
                            <strong>
                                {{ number_format($reste, 0, '', ' ') }}
                            </strong>
                            <sub>F</sub>
                        </td>
                    </tr>
                @endif
                @if ($show === 'true')
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary w-100">
                                Valider la commande
                            </button>
                        </td>
                    </tr>
                @endif

            </table>
        </form>
    </div>
</div>
