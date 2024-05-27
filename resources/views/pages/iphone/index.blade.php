<x-default dstyle="background: url('/iphones.jpg');">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100 opacity-80">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center gap-5 g-2">
                        <h4>iPhones</h4>
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
                                                    ~
                                                    {{ $iphone->modele->m_memoire }}
                                                    <sub>G0</sub>
                                                </strong>
                                            </td>
                                            <td>{{ $iphone->i_barcode }} </td>
                                            <td>
                                                @if (Request::get('f') == 'soft')
                                                    <form method="POST"
                                                        action="{{ route('iphone.restore', $iphone->i_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="bi bi-arrow-clockwise"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    {{ \App\Helpers\ModalHelper::action(
                                                        'editIphone',
                                                        '<i style="font-size: 1rem;" class="bi bi-pencil"></i>',
                                                        [
                                                            'route' => route('iphone.update', $iphone),
                                                            'datas' => json_encode($iphone),
                                                        ],
                                                        '',
                                                    ) }}

                                                    {{ \App\Helpers\ModalHelper::action(
                                                        'deleteIphone',
                                                        '<i style="font-size: 1rem;" class="bi bi-trash"></i>',
                                                        [
                                                            'route' => route('iphone.update', $iphone),
                                                            'datas' => json_encode($iphone),
                                                            'modele' => json_encode($iphone->modele),
                                                        ],
                                                        'btn btn-sm btn-danger rounded-circle',
                                                    ) }}
                                                @endif
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

    <!-- MODALS -->

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

<script>
    $(function() {
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
