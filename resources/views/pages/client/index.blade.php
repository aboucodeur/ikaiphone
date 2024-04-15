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
                                        <a href="{{ route('client.create') }}" class="btn btn-primary"><i
                                                class="bi bi-plus-circle-fill"></i> NOUVEAUX CLIENTS</a>
                                    </th>
                                    <th scope="col">TEL</th>
                                    <th scope="col">ADRESSE</th>
                                    <th scope="col">TYPE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $idx => $client)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ $client->c_nom }}</td>
                                        <td>{{ $client->c_tel }}</td>
                                        <td>{{ $client->c_adr }}</td>
                                        <td>{{ $client->c_type }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('client.edit', $client) }}" class="btn-sm btn-primary"
                                                role="button">
                                                <i data-feather="edit"></i>
                                            </a>
                                            {{-- avec suppression douce activer --}}
                                            <form method="POST" action="{{ route('client.destroy', $client) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm outline-none border-none">
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
