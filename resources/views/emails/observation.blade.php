<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Trámite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        p {
            margin-bottom: 15px;
        }

        .highlight {
            background-color: #ffc107;
            /* You can change this color as per your preference */
            padding: 10px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
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
    <div class="container">
        <h2>{{ config('app.name') }} / Trámite</h2>
        <p>Nuevo Comentario día: {{ now()->format('d/m/y H:i') }}</p>

        <p class="highlight">{{ $s_observacion }}</p>

        <div class="footer">
            <p>Gracias,<br>
                {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>

</html>