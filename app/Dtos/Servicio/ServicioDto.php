<?php

namespace App\Dtos\Servicio;

use App\Http\Requests\Mantenimiento\Servicio\StoreServicioRequest;
use App\Http\Requests\Mantenimiento\Servicio\UpdateServicioRequest;

class ServicioDto
{
    public function __construct(
       public readonly ?Int $i_estado,
      public readonly ?Int $i_formato,
      public readonly ?Int $i_rapidos,
      public readonly ?string $s_descripcion,
      public readonly ?string $s_generico,
      public readonly ?string $s_nombre,
    ){}

        public static function fromApiRequest(StoreServicioRequest|UpdateServicioRequest  $request): ServicioDto
        {
            
            return new self(
            i_estado: $request->validated('i_estado'),
            i_formato: $request->validated('i_formato'),
            i_rapidos: $request->validated('i_rapidos'),
            s_descripcion: $request->validated('s_descripcion'),
            s_generico: $request->validated('s_generico'),
            s_nombre: $request->validated('s_nombre'),
        );
}

}
