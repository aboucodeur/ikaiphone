<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A VERIFIER RELIQUATS DU {{ now() }}</title>
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

        .text-center {
            text-align: center;
        }

        .bg-orange {
            background-color: orange;
        }
    </style>
</head>

<body>
    <div id="main">
        <table>
            <thead>
                <tr>
                    <th colspan="5" style="background-color: lightgreen">
                        <center>{{ now() }} Reliquats</center>
                    </th>
                </tr>
                <tr>
                    <th colspan="5">
                        <center>A VERIFIER</center>
                    </th>
                </tr>
                <tr>
                    <th>NOM CLIENT</th>
                    <th>ARTICLE</th>
                    <th>MONTANT</th>
                    <th>PAIEMENT</th>
                    <th>RESTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reliquats_datas as $rd)
                    <tr>
                        <td class="text-center">{{ $rd->c_nom }}</td>
                        <td class="text-center">{{ $rd->m_nom }} {{ $rd->m_type }} {{ $rd->m_memoire }} </td>
                        <td class="text-center">
                            {{ number_format($rd->vc_prix, 0, '', ' ') }} <sup>F</sup>
                        </td>
                        <td class="text-center">
                            {{ number_format($rd->payer, 0, '', ' ') }} <sup>F</sup>
                        </td>
                        <td class="text-center bg-orange">
                            {{ number_format($rd->reste_a_payer, 0, '', ' ') }} <sup>F</sup>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
