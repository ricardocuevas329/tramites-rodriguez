<?php

namespace App\Services\Mantenimiento;

use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\DetalleRango;
use Illuminate\Http\Request;


class DetalleRangoService
{


  public function searchPrecioDistrito(Request $request)
  {

    $filtro = $request->search;
    $detalleRango = DetalleRango::where(function ($query) use ($filtro) {
      $query->filtros($filtro);
    })
      ->where('s_servicios','=','SE134')
      ->orderBy('s_codigo', 'asc')
      ->paginate(5);
    return CollectionResource::collection($detalleRango);
  }
}
