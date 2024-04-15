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
                                        <a href="{{ route('modele.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle-fill fs-8"></i> Nouveaux modele
                                        </a>
                                    </th>
                                    <th scope="col">TYPE</th>
                                    <th scope="col">MEMOIRE</th>
                                    <th scope="col">QTE</th>
                                    <th scope="col">PRIX</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modeles as $idx => $modele)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td class="w-15"><strong class="text-primary">{{ Str::upper($modele->m_nom) }}
                                                / {{ $modele->m_couleur }}</strong>
                                        </td>
                                        <td><strong class="text-primary">{{ $modele->m_type }}</strong></td>
                                        <td>
                                            <strong>{{ $modele->m_memoire }}</strong>
                                            <sub>GO</sub>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($modele->m_qte, 0, '', ' ') }}</strong>
                                        </td>
                                        <td><strong>{{ number_format($modele->m_prix, 0, '', ' ') }}</strong>
                                            <sub>F</sub>
                                        </td>
                                        <td class="d-flex gap-1 align-items-center">
                                            <a href="{{ route('modele.edit', $modele) }}" class="editModeleBtn"
                                                class="btn btn-sm btn-primary" role="button">
                                                <i data-feather="edit"></i>
                                            </a>

                                            <form id="delete_form" method="POST"
                                                action="{{ route('modele.destroy', $modele) }}">
                                                @method('DELETE')
                                                <button form="delete_form" type="submit"
                                                    class="btn btn-sm outline-none border-none">
                                                    @csrf
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
