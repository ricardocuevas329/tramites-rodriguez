<?php

namespace App\Dtos\Nacionalidad;

use App\Http\Requests\Mantenimiento\Nacionalidad\StoreNacionalidadRequest;
use App\Http\Requests\Mantenimiento\Nacionalidad\UpdateNacionalidadRequest;

class NacionalidadDto
{
    public function __construct(
  
      public readonly ?string $s_codigo_sbs,
      public readonly ?string $s_gentilicio,
      public readonly ?string $s_pais,
    ){}
        
        public static function fromApiRequest(StoreNacionalidadRequest|UpdateNacionalidadRequest  $request): NacionalidadDto
        {
            return new self(
          
            s_codigo_sbs: $request->validated('s_codigo_sbs'),
            s_gentilicio: $request->validated('s_gentilicio'),
            s_pais: $request->validated('s_pais'),
    );
}

}