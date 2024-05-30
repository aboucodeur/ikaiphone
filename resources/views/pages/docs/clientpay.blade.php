@php
    $sum_total = 0;
    $sum_pay = 0;
    $sum_rest = 0;
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture_client_{{ $client->c_nom }}</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        #main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }


        th,
        td {
            text-align: left;
            border: 1px solid black;
            padding: 3px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        #entete {
            width: 100%;
            height: 25%;
        }

        #divider {
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid black;
        }

        .header__right {
            margin-top: 20px;
        }

        #header__left {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="main">

        <div id="header">
            <div id="header__left">
                {{-- <img id="entete" src="{{ public_path('images/entete.jpg') }}" alt=""> --}}
                <h1>{{ $entreprise->en_nom }}</h1>
                <p>{{ $entreprise->en_desc }}</p>
                <p>{{ $entreprise->en_tel }}</p>
                <p>{{ $entreprise->en_adr }}</p>
            </div>
            <hr id="divider">
            <div class="header__right">
                <p>FACTURE NO : {{ $fact_id }} </p>
                <p><strong>Facture a : {{ Str::upper($client->c_nom) }}</strong></p>
                <p>Telephone : {{ $client->c_tel }}</p>
                <p>Date Facture : {{ date('Y/m/d') }}</p>
            </div>
        </div>

        <hr id="divider">
        Entreprise
        <div id="content">
            <table>
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Paye</th>
                        <th>Reste</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paiements as $idx => $p)
                        @php
                            $sum_total += $p->montant_total;
                            $sum_pay += $p->montant_paye;
                            $sum_rest += $p->montant_restant;
                        @endphp
                        <tr>
                            <td>
                                <center>
                                    {{ $p->modele }} {{ $p->m_type }} {{ $p->m_memoire }}
                                </center>
                            </td>
                            <td>
                                <center>
                                    {{ $p->i_barcode }}
                                </center>
                            </td>
                            <td>
                                <center>
                                    {{ number_format($p->montant_total, 0, '', ' ') }}
                                    <sup>F</sup>
                                </center>
                            </td>
                            <td>
                                <center>
                                    {{ number_format($p->montant_paye, 0, '', ' ') }}
                                    <sup>F</sup>
                                </center>
                            </td>
                            <td>
                                <center>
                                    {{ number_format($p->montant_restant, 0, '', ' ') }}
                                    <sup>F</sup>
                                </center>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <center>
                                TOTALS
                            </center>
                        </td>
                        <td colspan="2">
                            <center>
                                <strong>{{ number_format($sum_total, 0, '', ' ') }}</strong>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <center>
                                PAYE
                            </center>
                        </td>
                        <td colspan="2">
                            <center>
                                <strong>{{ number_format($sum_pay, 0, '', ' ') }}</strong>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <center>
                                RELIQUAT
                            </center>
                        </td>
                        <td colspan="2">
                            <center>
                                <strong>{{ number_format($sum_rest, 0, '', ' ') }}</strong>
                            </center>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
