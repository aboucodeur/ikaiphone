<x-default
    dstyle="background: url('/vendres.jpg');background-repeat: no-repeat;background-attachment: fixed;background-position: center;">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100 opacity-75">
                <div class="card-header">
                    <h4>VENTES</h4>
                    @include('pages.vendre.create')
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">Date de la vente</th>
                                    <th scope="col">Client / Revendeur</th>
                                    <th>Montant</th>
                                    <th>Reste</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendres as $idx => $vendre)
                                    @php
                                        $p = \App\Helpers\VendreHelper::paiementVendre($vendre);
                                    @endphp
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ explode(' ', $vendre->v_date)[0] }}</td>
                                        <td>{{ $vendre->client->c_nom }}</td>
                                        <td>{{ number_format($p['montant'], 0, '', ' ') }} <sub>F</sub></td>
                                        <td>{{ number_format($p['reste'], 0, '', ' ') }} <sub>F</sub></td>
                                        <td>{{ $vendre->v_type == 'REV' ? 'REVENDEUR' : 'SIMPLE' }}</td>
                                        <td class="d-flex w-100 align-items-center gap-1 flex-wrap">
                                            <a class="btn btn-sm btn-primary m-1"
                                                href="{{ route('vendre.show', $vendre) }}" role="button">
                                                {{-- <i data-feather="eye"></i> --}}
                                                Details
                                            </a>


                                            {{-- direct remove --}}
                                            @if ($vendre->v_etat < 1)
                                                <a class="btn-sm btn-primary" href="{{ route('vendre.edit', $vendre) }}"
                                                    role="button">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                <form method="POST" action="{{ route('vendre.destroy', $vendre) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="text-danger" data-feather="trash"></i>
                                                    </button>
                                                </form>
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
