@php
    $sum_debt = 0;
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture client</title>
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
            <center>
                <h3>LISTE DES IMPAYES</h3>
            </center>
            <div class="header__right">
                <p>DATE : {{ date('Y/m/d') }}</p>
            </div>
        </div>

        <hr id="divider">

        <div id="content">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Client</th>
                        <th scope="col">Modèle</th>
                        {{-- <th scope="col">IMEI</th> --}}
                        <th scope="col">Payer</th>
                        <th scope="col">Restants</th>
                        <th>Dernier paiement</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventes as $v)
                        <tr>
                            <td>{{ Str::upper($v->c_nom) }}</td>
                            <td class="strong">{{ $v->m_nom }} / {{ $v->m_type }} /
                                {{ $v->m_memoire }} (GO) / {{ $v->i_barcode }}</td>
                            {{-- <td>{{ $v->i_barcode }}</td> --}}
                            <td style="text-align: center">{{ number_format($v->montant, 0, '', ' ') }} <sub>F</sub>
                            </td>
                            <td style="text-align: center">{{ number_format($v->reste, 0, '', ' ') }} <sub>F</sub></td>
                            <td>{{ $v->dernier_paiement }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
