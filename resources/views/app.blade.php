<!DOCTYPE html>
<html data-theme="cupcake" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('app_name')}}</title>
        @vite(['resources/js/app.js' ])
        <link href="{{env('APP_URL')}}/libraries/daisy.full.min.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="antialiased h-screen bg-base-200 " >
     <div id="app"></div>
    </body>
</html>
