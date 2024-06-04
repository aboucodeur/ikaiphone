<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">RETOURS</h4>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Probleme</th>
                                    <th scope="col">Fournisseur</th>
                                    <th scope="col">iPhone remplacer</th>
                                    <th scope="col">iPhone remplacant</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retours as $idx => $retour)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ $retour->created_at }}</td>
                                        <td>{{ $retour->re_motif }}</td>
                                        <td>{{ $retour->iphoneRetourne?->achats->first()->fournisseur->f_nom ?? 'DEPUIS STOCKS' }}
                                        </td>
                                        <td>{{ $retour->iphoneRetourne->i_barcode }}</td>
                                        <td>{{ $retour->iphoneEchange->i_barcode }}</td>
                                        <td class="d-flex align-items-center flex-wrap">
                                            @if ($retour->etat < 1)
                                                {{-- Formulaire de validation --}}
                                                <form method="POST" action="{{ route('retour.valid', $retour) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button title="Confirmer le retour" type="submit"
                                                        class="btn btn-sm btn-primary">
                                                        <i data-feather="check"></i>
                                                    </button>
                                                </form>
                                                {{--
                                                {{ \App\Helpers\ModalHelper::action(
                                                    'delRet',
                                                    '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                    [
                                                        'route' => route('retour.destroy', $retour),
                                                        'datas' => json_encode($retour),
                                                    ],
                                                    'btn-sm btn-danger text-danger rounded-circle',
                                                ) }} --}}
                                            @else
                                                <span class="text-success">Valider</span>
                                            @endif

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
</x-default>
