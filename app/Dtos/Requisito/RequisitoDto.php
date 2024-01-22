<?php

namespace App\Dtos\Requisito;

use App\Http\Requests\Mantenimiento\Requisito\StoreRequisitoRequest;
use App\Http\Requests\Mantenimiento\Requisito\UpdateRequisitoRequest;

class RequisitoDto
{
    public function __construct(
      public readonly ?string $s_nombre,
      public readonly ?string $s_descripcion,
    ){}

        public static function fromApiRequest(StoreRequisitoRequest|UpdateRequisitoRequest  $request): RequisitoDto
        {
            return new self(
            s_nombre: $request->validated('s_nombre'),
            s_descripcion: $request->validated('s_descripcion'),
    );
}

}
