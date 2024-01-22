<?php

namespace App\Dtos\Profesion;

use App\Http\Requests\Administracion\Profesion\StoreProfesionRequest;
use App\Http\Requests\Administracion\Profesion\UpdateProfesionRequest;

class ProfesionDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_codigo_sbs,
      public readonly ?string $s_nombre,
      public readonly ?string $s_nombref,
      public readonly ?Int $i_tipo,
      public readonly ?string $s_descripcion,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreProfesionRequest|UpdateProfesionRequest  $request): ProfesionDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_codigo_sbs: $request->validated('s_codigo_sbs'),
            s_nombre: $request->validated('s_nombre'),
            s_nombref: $request->validated('s_nombref'),
            i_tipo: $request->validated('i_tipo'),
            s_descripcion: $request->validated('s_descripcion'),
            i_estado: $request->validated('i_estado'),
    );
}

}