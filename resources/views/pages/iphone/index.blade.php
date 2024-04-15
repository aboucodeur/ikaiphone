<x-default dstyle="background: url('/iphones.jpg');">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100 opacity-80">
                <div class="card-header">
                    <h4>iPhones listes</h4>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">NOM</th>
                                    <th scope="col">BARCODE / IMEI</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($iphones as $idx => $iphone)
                                    {{-- Souvent des modele d'iphones sont supprimer --}}
                                    @if ($iphone->modele)
                                        <tr>
                                            <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                            <td>
                                                <strong class="text-primary">
                                                    {{ Str::upper($iphone->modele->m_nom) }}
                                                    {{ Str::upper($iphone->modele->m_type) }}
                                                    {{ Str::upper($iphone->modele->m_couleur) }}
                                                    ~
                                                    {{ $iphone->modele->m_memoire }}
                                                    <sub>G0</sub>
                                                </strong>
                                            </td>
                                            <td>{{ $iphone->i_barcode }} </td>
                                            <td class="d-flex align-items-center">
                                                <a class="btn-sm btn-primary" href="{{ route('iphone.edit', $iphone) }}"
                                                    role="button">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                {{-- direct remove --}}
                                                <form method="POST" action="{{ route('iphone.destroy', $iphone) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="text-danger" data-feather="trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default>
