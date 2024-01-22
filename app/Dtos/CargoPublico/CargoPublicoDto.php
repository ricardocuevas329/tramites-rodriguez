<?php

namespace App\Dtos\CargoPublico;

use App\Http\Requests\Mantenimiento\CargoPublico\StoreCargoPublicoRequest;
use App\Http\Requests\Mantenimiento\CargoPublico\UpdateCargoPublicoRequest;

class CargoPublicoDto
{
    public function __construct(
       public readonly ?string $codigo,
      public readonly ?string $descripcion,
    ){}

        public static function fromApiRequest(StoreCargoPublicoRequest|UpdateCargoPublicoRequest  $request): CargoPublicoDto
        {
            return new self(
            codigo: $request->validated('codigo'),
            descripcion: $request->validated('descripcion'),
    );
}

}
