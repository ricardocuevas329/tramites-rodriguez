<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Trámite</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            margin-bottom: 15px;
        }

        .notification {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        @isset($kardex['s_tipokardex'], $kardex['s_kardex'])
        @if(!empty($kardex['s_tipokardex']) && !empty($kardex['s_kardex']))
        <h2>{{ config('app.name') }} / Trámite {{ $kardex['s_tipokardex'] }}-{{ $kardex['s_kardex'] }}</h2>
        @else
        <h2> {{ config('app.name') }} </h2>
        @endif
        @else
        <h2> {{ config('app.name') }} </h2>
        @endisset
        <div class="notification">Nuevos Documentos Agregados</div>
        <p>Ha recibido nuevos documentos, ¡Ver Adjuntos!</p>
        <div class="footer">
            <p>Gracias,<br>
                {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>

</html>