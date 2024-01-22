<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Trámite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>



<h2>{{ config('app.name') }} / Trámite</h2>
<p>Nuevo Trámite dia: {{now()->format('d/m/y H:i')}} </p>

<table>
    <tr>
        <th>Característica</th>
        <th>Detalles</th>
    </tr>
    <tr>
        <td>Apellido Paterno</td>
        <td>{{ $client['paterno']}}</td>
    </tr>
    <tr>
        <td>Apellido Materno</td>
        <td>{{ $client['materno']}}</td>
    </tr>
    <tr>
        <td>Nombres</td>
        <td>{{ $client['nombres']}}</td>
    </tr>
    <tr>
        <td>Tipo Documento</td>
        <td>{{ $tipo_doc}}</td>
    </tr>
    <tr>
        <td>Numero Documento</td>
        <td>{{ $client['documento']}}</td>
    </tr>

</table>


<p>Gracias,<br>
    {{ config('app.name') }}
</p>
</body>
</html>



