<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center g-2">
                        <h4 class="mb-0">RETOURS</h4>
                        {{ \App\Helpers\ModalHelper::trigger('addRet', '<i class="bi bi-plus-circle-fill"></i></a> Ajouter un retour', '') }}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Motif</th>
                                    <th scope="col">Fournisseur</th>
                                    <th scope="col">iPhone retourné</th>
                                    <th scope="col">iPhone échangé</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retours as $idx => $retour)
                                    <tr>
                                        <td scope="row" class="t_num">{{ $idx + 1 }}</td>
                                        <td>{{ $retour->re_date }}</td>
                                        <td>{{ $retour->re_motif }}</td>
                                        <td>{{ $retour->iphoneRetourne?->achats->first()->fournisseur->f_nom ?? 'APPROVISION DIRECTE' }}
                                        </td>
                                        <td>{{ $retour->iphoneRetourne->i_barcode }}</td>
                                        <td>{{ $retour->iphoneEchange->i_barcode }}</td>
                                        <td class="d-flex align-items-center flex-wrap">
                                            @if ($retour->etat < 1)
                                                {{-- Formulaire de validation --}}
                                                <form method="POST" action="{{ route('retour.valid', $retour) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i data-feather="check"></i>
                                                    </button>
                                                </form>

                                                {{ \App\Helpers\ModalHelper::action(
                                                    'delRet',
                                                    '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                    [
                                                        'route' => route('retour.destroy', $retour),
                                                        'datas' => json_encode($retour),
                                                    ],
                                                    'btn-sm btn-danger text-danger rounded-circle',
                                                ) }}
                                            @else
                                                <span class="text-success">Valider</span>
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

    <!-- MODALS -->
    @extends('includes.modal', [
        'id' => 'addRet',
        'fid' => 'faddRet',
        'title' => 'Effectuer un retour',
        'fmethod' => 'POST',
        'faction' => route('retour.store'),
        'b2Type' => 'submit',
    ])
    @section('content_addRet')
        @include('pages.retour.create')
    @endsection

    @extends('includes.modal', [
        'id' => 'delRet',
        'fid' => 'fdelRet',
        'title' => 'Suppression retour',
        'fmethod' => 'DELETE',
    ])
    @section('content_delRet')
        <p id="content_message_delRet"></p>
    @endsection
    @section('footer_delRet')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
        <button type="submit" class="btn btn-danger">OUI</button>
    @endsection

</x-default>

<script>
    $(function() {
        // Ajouter un retour
        $("#addRetBtn").click(function(e) {
            var form = $("#faddRet");
            setTimeout(() => {
                form.find("#barcode").focus()
            }, 700);
        });

        // Suppression retour
        $('.delRetBtn').click(function(e) {
            var datas = $(this).data('datas');
            var route = $(this).data('route');
            var form = $('#fdelRet');
            form.attr('action', route);
            form.find("#content_message_delRet").html(`
                <p>
                    Etes-vous sure de supprimer le retour ?
                </p>
            `)
        });

    });
</script>
