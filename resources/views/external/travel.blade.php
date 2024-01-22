<!DOCTYPE html>
<html data-theme="default" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permiso de Viaje</title>
    @vite(['resources/js/external.js' ])
    <link href="{{env('APP_URL')}}/libraries/daisy.full.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="antialiased h-screen" >
<div id="app"></div>
</body>
</html>
