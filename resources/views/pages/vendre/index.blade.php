<x-default>
    <div class="row">

        <div class="col-lg-12">
            @include('pages.vendre.create')
        </div>

        <div class="col-lg-12 mb-5">
            <div class="card h-100 shad">
                <div class="card-header">
                    <h4>VENTES</h4>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">CLIENT</th>
                                    <th>MONTANT</th>
                                    <th>RESTE</th>
                                    <th scope="col">TYPE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendres as $idx => $vendre)
                                    @php
                                        $p = \App\Helpers\VendreHelper::paiementVendre($vendre);
                                    @endphp
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>
                                            <strong>{{ $vendre->created_at }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('vendre.show', $vendre) }}">
                                                <strong>{{ Str::upper($vendre->client->c_nom) }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ number_format($p['montant'], 0, '', ' ') }} <sub>F</sub></td>
                                        <td>{{ number_format($p['reste'], 0, '', ' ') }} <sub>F</sub></td>
                                        <td>{{ $vendre->v_type == 'REV' ? 'REVENDEUR' : 'SIMPLE' }}</td>
                                        <td class="d-flex w-100 align-items-center gap-1 flex-wrap">
                                            <a class="btn btn-sm btn-primary m-1 rounded-circle"
                                                href="{{ route('vendre.show', $vendre) }}" role="button">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>


                                            {{-- direct remove --}}
                                            @if ($vendre->v_etat < 1)
                                                <a class="btn btn-sm rounded-circle btn-primary"
                                                    href="{{ route('vendre.edit', $vendre) }}" role="button">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form method="POST" action="{{ route('vendre.destroy', $vendre) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle">
                                                        <i class="bi bi-trash"></i>
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
