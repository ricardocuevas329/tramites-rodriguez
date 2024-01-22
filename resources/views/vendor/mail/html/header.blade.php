<?php
use App\Models\Administracion\Configuracion;
$config = Configuracion::first();
?>
@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
        <img src="{{$config?->s_ruta_logo}}" class="logo" alt="Logo"> <br>

{{ $slot }}
@endif
</a>
</td>
</tr>
