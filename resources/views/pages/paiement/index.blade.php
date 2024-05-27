<x-default>
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center gap-1 g-2">
                        <h4>PAIEMENTS</h4>

                        {{-- USER / EXPERIENCE FILTRE DE RECHERCHE --}}
                        <form method="GET">
                            <div class="d-flex align-items-center">
                                <div class="col">
                                    <span>Filtre de paiement :</span>
                                </div>
                                <div class="col-auto ms-2">
                                    <select onchange="submit();" name="pay" class="form-select form-select-sm">
                                        <option value="all" selected>Tous</option>
                                        <option {{ Request::get('pay') == 'np' ? 'selected' : '' }} value="np">
                                            Non Payer</option>
                                        <option {{ Request::get('pay') == 'p' ? 'selected' : '' }} value="p">
                                            Payer</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div>
                            <a class="btn btn-sm btn-warning text-white" href="{{ route('pdf.reliquat.pay') }}"
                                role="button" target="_blank">
                                <i class="bi bi-printer"></i>
                                RELIQUAT
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0 text-nowrap table-centered table-hover dt">
                            <thead class="table-light p-0 mb-0">
                                <tr>
                                    <th class="p-1 m-0 ns" scope="col">N</th>
                                    <th scope="col">PRODUIT</th>
                                    <th scope="col">CLIENT</th>
                                    <th scope="col">PAYER</th>
                                    <th scope="col">RESTE</th>
                                    <th scope="col">ETAT</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etats_pay_ventes as $idx => $epv)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>{{ $epv->m_nom }}</td>
                                        <td>{{ $epv->c_nom }}</td>
                                        <td>{{ number_format($epv->montant, 0, '', ' ') }}</td>
                                        <td>{{ number_format($epv->reste, 0, '', ' ') }}</td>
                                        <td>
                                            @if ($epv->etat_paiement == 'Payé')
                                                <span class="badge bg-primary">Payer</span>
                                            @else
                                                <span class="badge bg-danger">Pas payer</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a title="Payer" role="button"
                                                href="{{ route('vendre.paiement.index', [$epv->v_id, $epv->i_id]) }}"
                                                class="btn btn-sm btn-success" role="button">
                                                Payer
                                            </a>
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
