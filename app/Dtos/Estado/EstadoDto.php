<?php

namespace App\Dtos\Estado;

use App\Http\Requests\Mantenimiento\Estado\StoreEstadoRequest;
use App\Http\Requests\Mantenimiento\Estado\UpdateEstadoRequest;

class EstadoDto
{
    public function __construct(
      public readonly ?string $s_codigo_sbs,
      public readonly ?Int $s_tipo,
      public readonly ?string $s_desc,
    ){}

        public static function fromApiRequest(StoreEstadoRequest|UpdateEstadoRequest  $request): EstadoDto
        {
            return new self(
            s_codigo_sbs: $request->validated('s_codigo_sbs'),
            s_tipo: $request->validated('s_tipo'),
            s_desc: $request->validated('s_desc'),
    );
}

}
