<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center gap-1 g-2">
                        <h4>Fournisseurs</h4>
                        {{ \App\Helpers\ModalHelper::trigger('addFrs', '<i class="bi bi-plus-circle-fill"></i> NOUVEAUX FOURNISSEUR', '') }}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">FOURNISSEUR</th>
                                    <th scope="col">TEL</th>
                                    <th scope="col">ADRESSE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fournisseurs as $index => $fournisseur)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $index + 1 }}</td>
                                        <td><strong>{{ Str::upper($fournisseur->f_nom) }}</strong>
                                        </td>
                                        <td>{{ $fournisseur->f_tel }}</td>
                                        <td>{{ $fournisseur->f_adr }}</td>
                                        <td>

                                            {{ \App\Helpers\ModalHelper::action(
                                                'editFrs',
                                                '<i style="font-size: 1rem;" class="bi bi-pencil"></i>',
                                                ['datas' => json_encode($fournisseur), 'route' => route('fournisseur.update', $fournisseur)],
                                                '',
                                            ) }}

                                            {{ \App\Helpers\ModalHelper::action(
                                                'deleteFrs',
                                                '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                ['datas' => json_encode($fournisseur), 'route' => route('fournisseur.destroy', $fournisseur)],
                                                'btn btn-sm btn-danger rounded-circle',
                                            ) }}
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

    <!-- MODALS -->
    @extends('includes.modal', [
        'id' => 'addFrs',
        'fid' => 'faddFrs',
        'title' => 'Nouveaux fournisseur',
        'fmethod' => 'POST',
        'faction' => route('fournisseur.store'),
        'b2Type' => 'submit',
    ])
    @section('content_addFrs')
        @include('pages.fournisseur.create')
    @endsection

    @extends('includes.modal', [
        'id' => 'editFrs',
        'fid' => 'feditFrs',
        'title' => 'Modification fournisseur',
        'fmethod' => 'PUT',
        'b2Type' => 'submit',
    ])
    @section('content_editFrs')
        @include('pages.fournisseur.edit')
    @endsection

    @extends('includes.modal', [
        'id' => 'deleteFrs',
        'fid' => 'fdeleteFrs',
        'title' => 'Suppression fournisseur',
        'fmethod' => 'DELETE',
        'b2Type' => 'submit',
    ])
    @section('content_deleteFrs')
        <p id="content_message_deleteFrs"></p>
    @endsection
    @section('footer_deleteFrs')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-danger">Oui</button>
    @endsection


</x-default>

<script>
    $(function() {
        // Nouveaux fournisseur
        $('#addFrsBtn').click(function(e) {
            var modal = $("#faddFrs")
            setTimeout(() => {
                modal.find("#f_nom").focus()
            }, 1000);
        });

        // Modification fournisseur
        $('.editFrsBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#feditFrs');

            form.attr('action', route);

            setTimeout(() => {
                form.find('#f_nom').focus();
            }, 1000);

            // charger les valeur par defaut
            form.find('#f_nom').val(datas['f_nom'])
            form.find('#f_tel').val(datas['f_tel'])
            form.find('#f_adr').val(datas['f_adr'])

        });

        // Suppression fournisseur
        $('.deleteFrsBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#fdeleteFrs');
            form.attr('action', route);

            form.find("#content_message_deleteFrs").html(`
                <p>
                    Etes-vous sure de supprimer le fournisseur <strong>${datas['f_nom']}</strong>.
                </p>
            `)

        });

    });
</script>
