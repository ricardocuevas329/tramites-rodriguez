<?php

namespace App\Dtos\Cargo;

use App\Http\Requests\Mantenimiento\Cargo\StoreCargoRequest;
use App\Http\Requests\Mantenimiento\Cargo\UpdateCargoRequest;

class CargoDto
{
    public function __construct(
      public readonly ?string $s_descripcion,
      public readonly ?string $s_nombre,
    ){}

        public static function fromApiRequest(StoreCargoRequest|UpdateCargoRequest $request): CargoDto
        {
            return new self(
            s_descripcion: $request->validated('s_descripcion'),
            s_nombre: $request->validated('s_nombre'),
    );
}

}
