<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center g-2">
                        <h4>Clients</h4>
                        {{ \App\Helpers\ModalHelper::trigger('addClient', '<i class="bi bi-plus-circle-fill"></i> NOUVEAUX CLIENT', '') }}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">NOUVEAUX CLIENTS</th>
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
                                        <td>
                                            {{ \App\Helpers\ModalHelper::action(
                                                'editClient',
                                                '<i style="font-size: 1rem;" class="bi bi-pencil"></i>',
                                                ['datas' => json_encode($client), 'route' => route('client.update', $client)],
                                                '',
                                            ) }}

                                            {{ \App\Helpers\ModalHelper::action(
                                                'deleteClient',
                                                '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                ['datas' => json_encode($client), 'route' => route('client.destroy', $client)],
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
        'id' => 'addClient',
        'fid' => 'faddClient',
        'title' => 'Nouveaux client',
        'fmethod' => 'POST',
        'faction' => route('client.store'),
        'b2Type' => 'submit',
    ])
    @section('content_addClient')
        @include('pages.client.create')
    @endsection

    @extends('includes.modal', [
        'id' => 'editClient',
        'fid' => 'feditClient',
        'title' => 'Modification client',
        'fmethod' => 'PUT',
        'b2Type' => 'submit',
    ])
    @section('content_editClient')
        @include('pages.client.edit')
    @endsection

    @extends('includes.modal', [
        'id' => 'deleteClient',
        'fid' => 'fdeleteClient',
        'title' => 'Suppression client',
        'fmethod' => 'DELETE',
        'b2Type' => 'submit',
    ])
    @section('content_deleteClient')
        <p id="content_message_deleteClient"></p>
    @endsection
    @section('footer_deleteClient')
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

<script type="module" defer>
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

        // Nouveaux client
        $('#addClientBtn').click(function(e) {
            storeModal("addClient")
            var form = $("#faddClient")
            setTimeout(() => {
                form.find("#c_nom").focus()
            }, 1000);
        });

        // Modification client
        $('.editClientBtn').click(function(e) {
            storeModal("editClient")
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#feditClient');

            form.attr('action', route);

            setTimeout(() => {
                form.find('#c_nom').focus();
            }, 1000);

            // charger les valeur par defaut
            form.find('#c_nom').val(datas['c_nom'])
            form.find('#c_tel').val(datas['c_tel'])
            form.find('#c_adr').val(datas['c_adr'])

            $('#c_type option').each(function() {
                if ($(this).val() === datas['c_type']) {
                    $(this).prop('selected', true);
                    return false;
                }
            });

        });

        // Suppression client
        $('.deleteClientBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#fdeleteClient');
            form.attr('action', route);

            form.find("#content_message_deleteClient").html(`
                <p>
                    Etes-vous sure de supprimer le client <strong>${datas['c_nom']}</strong>.
                </p>
            `)

        });

    })
</script>
