<?php

namespace App\Dtos\Unidad;

use App\Http\Requests\Mantenimiento\Unidad\StoreUnidadRequest;
use App\Http\Requests\Mantenimiento\Unidad\UpdateUnidadRequest;

class UnidadDto
{
    public function __construct(
   
      public readonly ?string $s_nombre,
      public readonly ?string $s_abrev,
      public readonly ?string $s_observacion,
   
    ){}
        
        public static function fromApiRequest(StoreUnidadRequest|UpdateUnidadRequest  $request): UnidadDto
        {
            return new self(
            s_nombre: $request->validated('s_nombre'),
            s_abrev: $request->validated('s_abrev'),
            s_observacion: $request->validated('s_observacion'),
          
    );
}

}