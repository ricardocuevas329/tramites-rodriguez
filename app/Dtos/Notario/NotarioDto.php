<?php

namespace App\Dtos\Notario;

use App\Http\Requests\Entidad\Notario\StoreNotarioRequest;
use App\Http\Requests\Entidad\Notario\UpdateNotarioRequest;

class NotarioDto
{
    public function __construct(
      public readonly ?string $s_tipodoc,
      public readonly ?string $s_numdoc,
      public readonly ?string $s_paterno,
      public readonly ?string $s_materno,
      public readonly ?string $s_nombres,
      public readonly ?string $s_cargo,
      public readonly ?string $s_sexo,
      public readonly ?string $s_telefonos,
      public readonly ?string $s_observacion,
    ){}
        
        public static function fromApiRequest(StoreNotarioRequest|UpdateNotarioRequest  $request): NotarioDto
        {
            return new self(
            s_tipodoc: $request->validated('s_tipodoc'),
            s_numdoc: $request->validated('s_numdoc'),
            s_paterno: $request->validated('s_paterno'),
            s_materno: $request->validated('s_materno'),
            s_nombres: $request->validated('s_nombres'),
            s_cargo: $request->validated('s_cargo'),
            s_sexo: $request->validated('s_sexo'),
            s_telefonos: $request->validated('s_telefonos'),
            s_observacion: $request->validated('s_observacion'),
    );
}

}