<x-default appTitle="OKI">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center gap-5 g-2">
                        <h4>Modeles</h4>

                        <button id="addModeleBtn" type="button" class="btn btn-sm btn-primary btn-lg"
                            data-bs-toggle="modal" data-bs-target="#addModele">
                            <i class="bi bi-plus-circle-fill"></i> &nbsp;
                            Ajouter un modele
                        </button>

                        {{-- USER / EXPERIENCE SOFT DELETEION --}}
                        <form method="GET">
                            <div class="d-flex align-items-center">
                                <div class="col">
                                    <span>Filtre:</span>
                                </div>
                                <div class="col-auto ms-2">
                                    <select onchange="submit();" name="f" class="form-select form-select-sm">
                                        <option value="all" selected>Tous</option>
                                        <option {{ Request::get('f') == 'soft' ? 'selected' : '' }} value="soft">
                                            Corbeille</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">NOM</th>
                                    {{-- <th scope="col">TYPE</th> --}}
                                    <th scope="col">MEMOIRE</th>
                                    <th scope="col">QTE</th>
                                    <th scope="col">PRIX VENTE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modeles as $idx => $modele)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td class="w-15">
                                            <strong class="text-primary">{{ Str::upper($modele->m_nom) }}</strong>
                                            {{ $modele->m_type }}
                                        </td>
                                        {{-- <td><strong>{{ $modele->m_type }}</strong></td> --}}
                                        <td>
                                            <strong>{{ $modele->m_memoire }}</strong>
                                            <sub>GO</sub>
                                        </td>
                                        <td class="text-center">
                                            @if ($modele->m_qte > 0)
                                                <strong>{{ number_format($modele->m_qte, 0, '', ' ') }}</strong>
                                            @else
                                                <span class="badge bg-danger">
                                                    <strong>{{ number_format($modele->m_qte, 0, '', ' ') }}</strong>
                                                </span>
                                            @endif
                                        </td>
                                        <td><strong>{{ number_format($modele->m_prix, 0, '', ' ') }}</strong>
                                            <sub>F</sub>
                                        </td>
                                        <td>

                                            @if (Request::get('f') == 'soft')
                                                <form method="POST"
                                                    action="{{ route('modele.restore', $modele->m_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </form>
                                            @else
                                                {{ \App\Helpers\ModalHelper::action(
                                                    'editModele',
                                                    '<i style="font-size: 1rem;" class="bi bi-pencil"></i>',
                                                    [
                                                        'route' => route('modele.update', $modele),
                                                        'datas' => json_encode($modele),
                                                    ],
                                                    '',
                                                ) }}

                                                {{ \App\Helpers\ModalHelper::action(
                                                    'deleteModele',
                                                    '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                    [
                                                        'route' => route('modele.update', $modele),
                                                        'datas' => json_encode($modele),
                                                    ],
                                                    'btn btn-sm btn-danger rounded-circle',
                                                ) }}
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

    @extends('includes.modal', [
        'id' => 'addModele',
        'fid' => 'faddModele',
        'title' => 'Nouveaux modele',
        'fmethod' => 'POST',
        'faction' => route('modele.store'),
        'b2Type' => 'submit',
    ])
    @section('content_addModele')
        @include('pages.modele.create')
    @endsection

    @extends('includes.modal', [
        'id' => 'editModele',
        'fid' => 'feditModele',
        'title' => 'Modification modele',
        'fmethod' => 'PUT',
        'b2Type' => 'submit',
    ])
    @section('content_editModele')
        @include('pages.modele.edit')
    @endsection

    @extends('includes.modal', [
        'id' => 'deleteModele',
        'fid' => 'fdeleteModele',
        'title' => 'Suppression modele',
        'fmethod' => 'DELETE',
    ])
    @section('content_deleteModele')
        <p id="content_message_deleteModele"></p>
    @endsection
    @section('footer_deleteModele')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-danger">Oui</button>
    @endsection

</x-default>

@if (count($errors) > 0)
    <script>
        $(document).ready(function() {
            $(localStorage.getItem("l_modal")).modal('show')
        });
    </script>
@endif

<script>
    $(function() {

        function storeModal(idKey) {
            if (idKey) {
                const saved = localStorage.getItem('l_modal');
                if (saved !== idKey) localStorage.setItem('l_modal', "#" + idKey);
            }
        }

        function removeModal(idKey) {
            if (idKey) {
                const saved = localStorage.getItem('l_modal');
                if (saved) localStorage.removeItem('l_modal');
            }
        }

        // Nouveaux modele
        $('#addModeleBtn').click(function(e) {
            storeModal("addModele")
            var form = $('#faddModele');
            setTimeout(() => {
                form.find('#m_nom').focus();
            }, 1000);
        });

        // Modification modele
        $('.editModeleBtn').click(function(e) {
            storeModal("editModele")
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#feditModele');

            form.attr('method', 'POST');
            form.attr('action', route);

            setTimeout(() => {
                form.find('#m_nom').focus();
            }, 1000);

            // charger les valeur par defaut
            form.find('#m_nom').val(datas['m_nom'])
            form.find('#m_type').val(datas['m_type'])
            form.find('#m_prix').val(datas['m_prix'])
            form.find('#m_memoire').val(datas['m_memoire'])
        });

        // Suppression modele
        $('.deleteModeleBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#fdeleteModele');
            form.attr('action', route);

            form.find("#content_message_deleteModele").html(`
                <p>
                    Etes-vous sure de supprimer le modele <strong>${datas['m_nom']}</strong> de type
                    <strong>${datas['m_type']}</strong> avec une memoire de <strong>${datas['m_memoire']}</strong> GO.
                </p>
            `)

        });

    })
</script>
