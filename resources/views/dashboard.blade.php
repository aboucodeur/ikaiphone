<x-default>
    <div class="bg-secondary pt-10 pb-21 mt-n6 mx-n4"></div>
    <div class="container-fluid mt-n22 ">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0  text-white">Salut, {{ Auth::user()->u_prenom }} {{ Auth::user()->u_nom }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Stocks -->
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                <div class="card h-100 card-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">STOCKS</h4>
                            </div>
                            <div class="icon-shape icon-lg  text-primary">
                                <i class="bi bi-phone" style="font-size: 3em"></i>
                            </div>
                        </div>
                        <div class="lh-1">
                            <h1 class=" mb-1 fw-bold">{{ $stocks }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Clients -->
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                <div class="card h-100 card-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Clients</h4>
                            </div>
                            <div class="icon-shape icon-lg  text-primary">
                                <i class="bi bi-people" style="font-size: 2em"></i>
                            </div>
                        </div>
                        <div class="lh-1">
                            <h1 class="  mb-1 fw-bold">{{ $clients }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fournisseurs --}}
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                <div class="card h-100 card-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Fournisseurs</h4>
                            </div>
                            <div class="icon-shape icon-lg  text-primary">
                                <i class="bi bi-truck" style="font-size: 2em"></i>
                            </div>
                        </div>
                        <div class="lh-1">
                            <h1 class="  mb-1 fw-bold">{{ $frs }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Nombres de retours --}}
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
                <div class="card h-100 card-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Retours</h4>
                            </div>
                            <div class="icon-shape icon-lg  text-primary">
                                <i class="bi bi-arrow-down-up" style="font-size: 2em"></i>
                            </div>
                        </div>
                        <div class="lh-1">
                            <h1 class="  mb-1 fw-bold">{{ $rets }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Etat des ventes d'iphones -->
        <div class="row ">
            <div class="col-xl-8 col-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-sm btn-primary w-100" href="{{ route('pdfventes') }}" role="button">
                            <i class="bi bi-printer" style="font-size: 1em;"></i> &nbsp;
                        </a>
                        <h4 class="text-center mt-1 mb-1">Etat de paiements des iphones</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table text-nowrap mb-0 table-centered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Client</th>
                                        <th>Modele</th>
                                        <th>Date paiement</th>
                                        <th>Montant</th>
                                        <th>Reste</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventes as $v)
                                        <tr>
                                            <td><strong>{{ Str::upper($v->c_nom) }}</strong></td>
                                            <td class="text-primary"><strong>{{ Str::upper($v->m_nom) }}</strong></td>
                                            <td>{{ $v->dernier_paiement }}</td>
                                            <td><strong>{{ number_format($v->montant, 0, '', ' ') }}</strong>
                                                <sub>F</sub>
                                            </td>
                                            <td><strong>{{ number_format($v->reste, 0, '', ' ') }}</strong>
                                                <sub>F</sub>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-5 ">
                <!-- card  -->
                <div class="card h-100">
                    <!-- card body  -->
                    <div class="card-header d-flex align-items-center
                    justify-content-between">
                        <div>
                            <h4 class="mb-0">Tasks Performance </h4>
                        </div>

                        <!-- dropdown  -->
                        <div class="dropdown dropstart">
                            <a class="btn btn-icon btn-ghost btn-sm rounded-circle" href="#!" role="button"
                                id="dropdownTask" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-xs" data-feather="more-vertical"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownTask">
                                <a class="dropdown-item d-flex align-items-center" href="#!">Action</a>
                                <a class="dropdown-item d-flex align-items-center" href="#!">Another
                                    action</a>
                                <a class="dropdown-item d-flex align-items-center" href="#!">Something else
                                    here</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- chart  -->
                        <div class="mb-6">
                            <div id="perfomanceChart"></div>
                        </div>
                        <!-- icon with content  -->
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="text-center">
                                <i class="icon-sm text-success" data-feather="check-circle"></i>
                                <h1 class="fs-2 mb-0 ">76%</h1>
                                <p>Completed</p>
                            </div>
                            <div class="text-center">
                                <i class="icon-sm text-warning" data-feather="trending-up"></i>
                                <h1 class="fs-2 mb-0 ">32%</h1>
                                <p>In-Progress</p>
                            </div>
                            <div class="text-center">
                                <i class="icon-sm text-danger" data-feather="trending-down"></i>
                                <h1 class="fs-2 mb-0 ">13%</h1>
                                <p>Behind</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

</x-default>
