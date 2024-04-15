<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center mb-0 m-0">
                    <h4 class="mb-0">Réductions</h4>
                    <a href="{{ route('reduction.create') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus-circle-fill"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">ID</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Pourcentage</th>
                                    <th scope="col">Créé le</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reductions as $reduction)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $reduction->r_id }}</td>
                                        <td>{{ $reduction->r_nom }}</td>
                                        <td>{{ $reduction->r_type }}</td>
                                        <td>{{ (int) $reduction->r_pourcentage }} <sub>%</sub></td>
                                        <td>{{ $reduction->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="d-flex align-items-center">
                                            <a class="btn-sm btn-primary"
                                                href="{{ route('reduction.edit', $reduction) }}" role="button">
                                                <i data-feather="edit"></i>
                                            </a>
                                            {{-- direct remove --}}
                                            <form method="POST" action="{{ route('reduction.destroy', $reduction) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm">
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
