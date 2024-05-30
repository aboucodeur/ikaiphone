<x-default>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between mb-5 align-items-center">
                <h3 class="mb-0 text-success">STATS</h3>
                <a href="{{ route('paiement.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-bank"></i> &nbsp;
                    Paiements
                </a>
            </div>
        </div>
    </div>
    <div class="row row-cols-1  row-cols-xl-4 row-cols-md-2 ">
        <div class="col mb-5">
            <div class="card h-100 card-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semi-bold ">Stock</span>
                        <img width="25px" class="m-1" src="/assets/images/svg/delivery-truck.svg" alt="truck">
                        {{-- <span><i data-feather="truck" class="text-info"></i></span> --}}

                    </div>
                    <div class="mt-4 mb-3 d-flex align-items-center lh-1">
                        <h3 class="fw-bold  mb-0">{{ $stocks }}</h3>
                        {{-- <span class="mt-1 ms-2 text-danger "><i data-feather="arrow-down"class="icon-xs"></i>2.29%</span> --}}
                    </div>
                    <a href="{{ route('modele.index') }}" class="btn-link fw-semi-bold">Voir le stock</a>
                </div>
            </div>
        </div>
        <div class="col mb-5">
            <div class="card h-100 card-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semi-bold ">Retours</span>
                        <img width="25px" class="m-1" src="/assets/images/svg/arrow-back.svg" alt="arrow-back">
                        {{-- <span><i data-feather="dollar-sign" class="text-info"></i></span> --}}
                    </div>
                    <div class="mt-4 mb-3 d-flex align-items-center lh-1">
                        <h3 class="fw-bold  mb-0">{{ $rets }}</h3>
                    </div>
                    <a href="{{ route('retour.index') }}" class="btn-link fw-semi-bold">Voir les retours</a>
                </div>
            </div>
        </div>
        <div class="col mb-5">
            <div class="card h-100 card-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semi-bold ">Clients</span>
                        <img width="25px" class="m-1" src="/assets/images/svg/group.svg" alt="group">
                        {{-- <span><i data-feather="user" class="text-info"></i></span> --}}

                    </div>
                    <div class="mt-4 mb-3 d-flex align-items-center lh-1">
                        <h3 class="fw-bold  mb-0">{{ $clients }}</h3>
                    </div>
                    <a href="{{ route('client.index') }}" class="btn-link fw-semi-bold">Voir Clients</a>
                </div>
            </div>
        </div>
        <div class="col mb-5">
            <div class="card h-100 card-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semi-bold ">Ventes</span>
                        {{-- <span><i data-feather="credit-card" class="text-info"></i></span> --}}
                        <img width="25px" class="m-1" src="/assets/images/svg/shopping-cart-outline.svg" alt="shopping-cart-outline">

                    </div>
                    <div class="mt-4 mb-3 d-flex align-items-center lh-1">
                        <h3 class="fw-bold  mb-0">{{ $ventes }}</h3>

                    </div>
                    <a href="{{ route('vendre.index') }}" class="btn-link fw-semi-bold">Voir les ventes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Etat de paiements des 3 derniers mois avec les graphes -->
    <div class="row">
        <div class="col-lg-6 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center g-2">
                        <h4 class="mb-0 text-center">
                            Recette du jours {{ date('d/m/Y H:i') }}
                            <strong>
                                {{ number_format($somme_recette, 0, '', ' ') }} <sup>F</sup>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <div class="t-responsive">
                            <table class="table text-nowrap mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">CLIENT</th>
                                        <th scope="col">PRIX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recette_jours as $rj)
                                        <tr>
                                            <td>{{ $rj->client }}</td>
                                            <td class="text-center">
                                                {{ number_format($rj->montant_payer, 0, '', ' ') }} <sup>F</sup>
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

        <div class="col-lg-6 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center g-2">
                        <h4 class="mb-0">Impayes par client</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <div class="t-responsive">
                            <table class="table text-nowrap mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>CLIENT</th>
                                        <th>NB. COMMANDE</th>
                                        <th>Facture</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients_commandes as $cc)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ Str::upper($cc->c_nom) }}</strong>
                                            </td>
                                            <td>
                                                A
                                                <span class="badge badge-success-soft text-success">
                                                    {{ $cc->nombre_dettes }}
                                                </span> commande(s) impayée(s)
                                            </td>
                                            <td>
                                                <a target="_blank" class="btn btn-sm btn-primary"
                                                    href="{{ route('pdf.client.pay', $cc->c_id) }}" role="button">
                                                    <i class="bi bi-printer"></i>
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

        <div class="col-lg-12 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center g-2">
                        <h4 class="mb-0">Iphones sorties et impayes des 3 derniers mois</h4>
                        <a target="_blank" class="btn btn-sm btn-primary" href="{{ route('pdf.all.pay') }}"
                            role="button">Impriner</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table text-nowrap mb-0 table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th>PRODUIT</th>
                                    <th>CLIENT</th>
                                    <th>PAYER</th>
                                    <th>RESTE</th>
                                    <th>DATE DU DERNIER</th>
                                    <th>ETAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etats_pay_ventes as $ep)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ Str::upper($ep->m_nom) }}</strong>
                                        </td>
                                        <td>
                                            {{ Str::upper($ep->c_nom) }}
                                        </td>
                                        <td>
                                            <strong>{{ number_format($ep->montant, 0, '', ' ') }}</strong>
                                            <sub>F</sub>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($ep->reste, 0, '', ' ') }}</strong>
                                            <sub>F</sub>
                                        </td>
                                        <td class="text-center">
                                            {{ $ep->dernier_paiement ?? '-' }}
                                        </td>
                                        <td>
                                            @if ($ep->reste == '0')
                                                <span class="badge bg-success">Payer</span>
                                            @else
                                                <span class="badge bg-danger">Pas Payer</span>
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

        <!-- Graphes des top 10 modeles -->
        <div class="col-lg-6 mb-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Top 10 des modeles vendus</h4>
                </div>
                <div class="card-body">
                    <div id="chartModeleIphone" data-vi="{{ json_encode($ventes_per_iphones) }}"></div>
                </div>
            </div>
        </div>

        <!-- Graphes des top 10 clients -->
        <div class="col-lg-6 mb-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Top 10 des clients</h4>
                </div>
                <div class="card-body">
                    <div id="chartVenteClient" data-vc="{{ json_encode($ventes_per_clients) }}"></div>
                </div>
            </div>
        </div>
    </div>
</x-default>

<script>
    $(function() {
        var e;

        // ** GRAPHES
        const vpiEl = $("#chartModeleIphone");
        const vpiDatas = vpiEl.data("vi") || [];
        const max1 = Math.max(...vpiDatas?.map((d) => d.total_ventes));
        if ($("#chartModeleIphone"))
            $("#chartModeleIphone").length &&
            ((e = {
                    series: [{
                        name: "Ventes",
                        type: "line",
                        data: vpiDatas.map((d) => d.total_ventes),
                    }, ],
                    chart: {
                        height: 300,
                        type: "line",
                        stacked: !1,
                        toolbar: {
                            show: !1
                        },
                    },
                    legend: {
                        show: !1
                    },
                    grid: {
                        borderColor: window.theme.gray300
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 90, 100],
                        },
                    },
                    colors: ["#624bff", "#198754"],
                    stroke: {
                        width: [2, 2],
                        curve: "smooth",
                        colors: ["#624BFF", "#198754"],
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "50%"
                        }
                    },
                    labels: vpiDatas.map((d) => d.m_nom),
                    markers: {
                        size: 0
                    },
                    xaxis: {
                        min: 1,
                        labels: {
                            style: {
                                fontSize: "11px",
                                fontWeight: 400,
                                colors: "#1e293b",
                                fontFamily: '"Inter", "sans-serif"',
                            },
                        },
                        axisBorder: {
                            show: !0,
                            color: window.theme.gray300,
                            height: 1,
                            width: "100%",
                            offsetX: 0,
                            offsetY: 0,
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: window.theme.gray300,
                            height: 6,
                            offsetX: 0,
                            offsetY: 0,
                        },
                    },
                    yaxis: {
                        type: "numeric",
                        tickAmount: max1, // doit etre la valeur maximun car la boucle genere en fonction
                        min: 0,
                        labels: {
                            formatter: function(val) {
                                return parseFloat(val);
                            },
                            style: {
                                fontSize: "14px",
                                fontWeight: 400,
                                colors: "#1e293b",
                                fontFamily: '"Inter", "sans-serif"',
                            },
                        },
                    },
                    tooltip: {
                        shared: !0,
                        intersect: !1,
                        y: {
                            formatter: function(e) {
                                return void 0 !== e ? e.toFixed(0) + "" : e;
                            },
                        },
                    },
                }),
                new ApexCharts(document.querySelector("#chartModeleIphone"), e).render());



        const vpcEl = $("#chartVenteClient");
        const vpcDatas = vpcEl.data("vc") || [];
        const max2 = Math.max(...vpcDatas?.map((d) => d.nb_ventes));
        if ($("#chartVenteClient"))
            $("#chartVenteClient").length &&
            ((e = {
                    series: [{
                        name: "Ventes",
                        type: "line",
                        data: vpcDatas.map((d) => d.nb_ventes),
                    }, ],
                    chart: {
                        height: 300,
                        type: "line",
                        stacked: !1,
                        toolbar: {
                            show: !1
                        },
                    },
                    legend: {
                        show: !1
                    },
                    grid: {
                        borderColor: window.theme.gray300
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 90, 100],
                        },
                    },
                    colors: ["#624bff", "#198754"],
                    stroke: {
                        width: [2, 2],
                        curve: "smooth",
                        colors: ["#624BFF", "#198754"],
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "50%"
                        }
                    },
                    labels: vpcDatas.map((d) => d.c_nom),
                    markers: {
                        size: 0
                    },
                    xaxis: {
                        min: 1,
                        labels: {
                            style: {
                                fontSize: "11px",
                                fontWeight: 400,
                                colors: "#1e293b",
                                fontFamily: '"Inter", "sans-serif"',
                            },
                        },
                        axisBorder: {
                            show: !0,
                            color: window.theme.gray300,
                            height: 1,
                            width: "100%",
                            offsetX: 0,
                            offsetY: 0,
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: window.theme.gray300,
                            height: 6,
                            offsetX: 0,
                            offsetY: 0,
                        },
                    },
                    yaxis: {
                        type: "numeric",
                        tickAmount: max2, // doit etre la valeur maximun car la boucle genere en fonction
                        min: 0,
                        labels: {
                            formatter: function(val) {
                                return parseFloat(val);
                            },
                            style: {
                                fontSize: "14px",
                                fontWeight: 400,
                                colors: "#1e293b",
                                fontFamily: '"Inter", "sans-serif"',
                            },
                        },
                    },
                    tooltip: {
                        shared: !0,
                        intersect: !1,
                        y: {
                            formatter: function(e) {
                                return void 0 !== e ? e.toFixed(0) + "" : e;
                            },
                        },
                    },
                }),
                new ApexCharts(document.querySelector("#chartVenteClient"), e).render());
    });
</script>
