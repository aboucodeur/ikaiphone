<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de vente</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        #main {
            padding: 10px;
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
    </style>
</head>

<body>
    <div id="main">
        <div>
            <h3 style="text-align: center;">Imprimer le {{ now()->toDateString() }}</h3>
            <p>Mois : {{ now()->format('m') }} Mois</p>
            <p>Année : {{ now()->year }}</p>
        </div>
        <div>
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
                            <td class="strong">{{ $v->m_nom }} / {{ $v->m_type }} / {{ $v->m_couleur }} /
                                {{ $v->m_memoire }} (GO)</td>
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
