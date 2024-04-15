<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">RETOURS</h4>
                    {{-- Bouton pour ajouter un nouveau retour --}}
                    <a href="{{ route('retour.create') }}" class="btn btn-primary btn-sm">
                        Ajouter un retour &nbsp;<i class="bi bi-plus-circle-fill"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Motif</th>
                                    <th scope="col">Fournisseur</th>
                                    <th scope="col">iPhone retourné</th>
                                    <th scope="col">iPhone échangé</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retours as $idx => $retour)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ $retour->re_date }}</td>
                                        <td>{{ $retour->re_motif }}</td>
                                        <td>{{ $retour->iphoneRetourne->achats->first()->fournisseur->f_nom }}</td>
                                        <td>{{ $retour->iphoneRetourne->i_barcode }}</td>
                                        <td>{{ $retour->iphoneEchange->i_barcode }}</td>
                                        <td class="d-flex align-items-center flex-wrap">
                                            @if ($retour->etat < 1)
                                                {{-- Formulaire de validation --}}
                                                <form method="POST" action="{{ route('retour.valid', $retour) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i data-feather="check"></i>
                                                    </button>
                                                </form>
                                                {{-- Formulaire de suppression --}}
                                                <form method="POST" action="{{ route('retour.destroy', $retour) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="text-danger" data-feather="trash"></i>
                                                    </button>
                                                </form>
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
