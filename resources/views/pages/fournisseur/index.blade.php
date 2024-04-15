<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">
                                        <a href="{{ route('fournisseur.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle-fill"></i> NOUVEAUX FOURNISSEUR
                                        </a>
                                    </th>
                                    <th scope="col">TEL</th>
                                    <th scope="col">ADRESSE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fournisseurs as $index => $fournisseur)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $index + 1 }}</td>
                                        <td class="text-center"><strong>{{ Str::upper($fournisseur->f_nom) }}</strong>
                                        </td>
                                        <td>{{ $fournisseur->f_tel }}</td>
                                        <td>{{ $fournisseur->f_adr }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('fournisseur.edit', $fournisseur) }}"
                                                class="btn-sm btn-primary" role="button">
                                                <i data-feather="edit"></i>
                                            </a>
                                            {{-- avec suppression douce activer --}}
                                            <form method="POST"
                                                action="{{ route('fournisseur.destroy', $fournisseur) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')"
                                                    type="submit" class="btn btn-sm outline-none border-none">
                                                    <i class="text-danger" data-feather="trash"></i>
                                                </button>
                                            </form>
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
