<?php

namespace App\Dtos\ComparecienteBloqueado;

use App\Http\Requests\Entidad\ComparecienteBloqueado\StoreComparecienteBloqueadoRequest;
use App\Http\Requests\Entidad\ComparecienteBloqueado\UpdateComparecienteBloqueadoRequest;

class ComparecienteBloqueadoDto
{
    public function __construct(
      public readonly ?Int $s_condicion,
      public readonly ?string $s_numero,
      public readonly ?string $s_observacion,
      public readonly ?string $s_referencia,
      public readonly ?string $s_ruta,
      public readonly ?Array $comparecientes,

    ){}

        public static function fromApiRequest(StoreComparecienteBloqueadoRequest|UpdateComparecienteBloqueadoRequest  $request): ComparecienteBloqueadoDto
        {
            return new self(
            s_condicion: $request->validated('s_condicion'),
            s_numero: $request->validated('s_numero'),
            s_observacion: $request->validated('s_observacion'),
            s_referencia: $request->validated('s_referencia'),
            s_ruta: $request->validated('s_ruta'),
            comparecientes: $request->validated('comparecientes'),
    );
}

}
