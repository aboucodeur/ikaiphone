<x-default
    dstyle="background: url('/achats.jpg');background-repeat: no-repeat;background-attachment: fixed;background-position: center;">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100 opacity-80">
                <div class="card-header">
                    <h4>Achats (arrivages)</h4>
                    <form method="POST" action="{{ route('achat.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <input autofocus type="date" class="form-control" name="a_date" id="a_date"
                                        value="{{ old('a_date', date('Y-m-d')) }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <select class="form-select" id="f_id" name="f_id" required>
                                        <option value="">Sélectionner un fournisseur</option>
                                        @foreach ($frs as $fr)
                                            <option value="{{ $fr->f_id }}">{{ $fr->f_nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-secondary w-100">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Fournisseur</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($achats as $idx => $achat)
                                    @php
                                        $mte = 0;
                                        $iphones = $achat->iphones;
                                        foreach ($iphones as $key => $iphone) {
                                            $mte += $iphone->pivot->ac_prix;
                                        }
                                    @endphp
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ explode(' ', $achat->a_date)[0] }}</td>
                                        <td>{{ $achat->fournisseur->f_nom }}</td>
                                        <td>{{ number_format($mte, 0, '', ' ') }} <sub>F</sub></td>
                                        <td class="d-flex w-100 align-items-center gap-1 flex-wrap">
                                            <a class="btn btn-sm btn-primary m-1"
                                                href="{{ route('achat.show', $achat) }}" role="button">
                                                Details
                                            </a>

                                            @if ($achat->a_etat < 1)
                                                <a class="btn-sm btn-primary" href="{{ route('achat.edit', $achat) }}"
                                                    role="button">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                <form id="f1" method="POST"
                                                    action="{{ route('achat.destroy', $achat) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="$(this).closest('form').submit()"
                                                        class="btn btn-sm">
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
