<x-default>
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
                                            <details>
                                                <summary>
                                                    <strong
                                                        class="text-primary">{{ Str::upper($modele->m_nom) }}</strong>
                                                    {{ $modele->m_type }} ~ {{ $modele->m_memoire }} (GO)
                                                </summary>
                                                {{-- Afficher tous les iphones qui decoules de ce modele --}}
                                                <div class="mt-1">
                                                    @if (empty($modele->iphones))
                                                        <p class="text-center">Aucun iPhone trouvé</p>
                                                    @else
                                                    @endif
                                                    <table class="table">
                                                        @foreach ($modele->iphones as $iphone)
                                                            <tr>
                                                                <td>
                                                                    <p class="m-0 font-bold">
                                                                        IMEI : {{ $iphone->i_barcode }}
                                                                        /
                                                                        Etat :
                                                                        {{ $iphone->ventes->count() > 0 ? 'Vendu' : '----' }}
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    {{ \App\Helpers\ModalHelper::action(
                                                                        'editIphone',
                                                                        '<i style="font-size: 1rem;" class="bi bi-pencil"></i>',
                                                                        [
                                                                            'route' => route('iphone.update', $iphone),
                                                                            'datas' => json_encode($iphone),
                                                                        ],
                                                                        'btn-sm',
                                                                    ) }}

                                                                    {{ \App\Helpers\ModalHelper::action(
                                                                        'deleteIphone',
                                                                        '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                                        [
                                                                            'route' => route('iphone.update', $iphone),
                                                                            'datas' => json_encode($iphone),
                                                                            'modele' => json_encode($iphone->modele),
                                                                        ],
                                                                        'btn-sm btn-danger text-danger rounded-circle',
                                                                    ) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </details>
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

    {{-- MAIN MODAL --}}
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

    {{-- IPHONE MODAL --}}
    @extends('includes.modal', [
        'id' => 'editIphone',
        'title' => 'Modification iPhone',
        'fid' => 'feditIphone',
        'fmethod' => 'PUT',
        'b2Type' => 'submit',
    ])
    @section('content_editIphone')
        @include('pages.iphone.edit', compact('modeles'))
    @endsection

    @extends('includes.modal', [
        'id' => 'deleteIphone',
        'title' => 'Modification iPhone',
        'fid' => 'fdeleteIphone',
        'fmethod' => 'DELETE',
        'b2Type' => 'submit',
    ])
    @section('content_deleteIphone')
        <p id="content_message_deleteIphone"></p>
    @endsection
    @section('footer_deleteIphone')
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

        //**MODELE**//

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

        // **IPHONE**//
        // Modification iphone
        $('.editIphoneBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#feditIphone');
            form.attr('action', route);

            setTimeout(() => {
                form.find('#i_barcode').focus();
            }, 1000);

            form.find("#i_barcode").val(datas['i_barcode'])
            $('#m_id option').each(function() {
                if ($(this).val() == datas['m_id']) {
                    $(this).prop('selected', true);
                    return false;
                }
            });

        });

        // Suppression modele
        $('.deleteIphoneBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var modele = $(this).data('modele');

            var form = $('#fdeleteIphone');
            form.attr('action', route);

            form.find("#content_message_deleteIphone").html(`
                <p>
                    Etes-vous sure de supprimer l'iphone <strong>${modele['m_nom']}</strong>
                    avec le code bare ${datas['i_barcode']}.
                </p>
            `)

        });

    })
</script>
