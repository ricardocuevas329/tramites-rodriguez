<?php

namespace App\Dtos\Abogado;

use App\Http\Requests\Entidad\Abogado\StoreAbogadoRequest;
use App\Http\Requests\Entidad\Abogado\UpdateAbogadoRequest;

class AbogadoDto
{
    public function __construct(
       
      public readonly ?string $s_paterno,
      public readonly ?string $s_materno,
      public readonly ?string $s_nombres,
      public readonly ?string $s_sexo,
      public readonly ?string $s_telefono,
      public readonly ?string $s_cal,
      public readonly ?string $s_colegio,
      public readonly ?string $s_personal,
     
    ){}
        
        public static function fromApiRequest(StoreAbogadoRequest|UpdateAbogadoRequest  $request): AbogadoDto
        {
            return new self(
            
            s_paterno: $request->validated('s_paterno'),
            s_materno: $request->validated('s_materno'),
            s_nombres: $request->validated('s_nombres'),
            s_sexo: $request->validated('s_sexo'),
            s_telefono: $request->validated('s_telefono'),
            s_cal: $request->validated('s_cal'),
            s_colegio: $request->validated('s_colegio'),
            s_personal: $request->validated('s_personal'),
            
    );
}

}