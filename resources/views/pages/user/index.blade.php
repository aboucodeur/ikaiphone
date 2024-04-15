<x-default dstyle="background: url('/iphones.jpg');">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100 opacity-80">
                <div class="card-header">
                    <h4>Utilisateurs</h4>
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle-fill"></i> NOUVEAUX UTILISATEUR
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">NOM COMPLET</th>
                                    <th scope="col">UTILISATEUR</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">TYPE</th>
                                    {{-- <th scope="col">ACTION</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $idx => $user)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ Str::upper($user->u_prenom) }}
                                                {{ Str::upper($user->u_nom) }}</strong></td>
                                        <td>{{ $user->u_username }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td><strong>{{ Str::upper($user->u_type) }}</strong></td>
                                        {{-- <td></td> --}}
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
