<?php

namespace App\Dtos\Accion;

use App\Http\Requests\Administracion\Accion\StoreAccionRequest;
use App\Http\Requests\Administracion\Accion\UpdateAccionRequest;

class AccionDto
{
    public function __construct(
       public readonly ?Int $i_codigo,
      public readonly ?string $s_codper,
      public readonly ?string $s_nombre,
      public readonly ?string $s_descripcion,
      public readonly ?string $s_objeto,
      public readonly ?string $d_fecha_reg,
      public readonly ?string $s_personal_reg,
      public readonly ?string $d_fecha_mod,
      public readonly ?string $s_personal_mod,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreAccionRequest|UpdateAccionRequest  $request): AccionDto
        {
            return new self(
            i_codigo: $request->validated('i_codigo'),
            s_codper: $request->validated('s_codper'),
            s_nombre: $request->validated('s_nombre'),
            s_descripcion: $request->validated('s_descripcion'),
            s_objeto: $request->validated('s_objeto'),
            d_fecha_reg: $request->validated('d_fecha_reg'),
            s_personal_reg: $request->validated('s_personal_reg'),
            d_fecha_mod: $request->validated('d_fecha_mod'),
            s_personal_mod: $request->validated('s_personal_mod'),
            i_estado: $request->validated('i_estado'),
    );
}

}