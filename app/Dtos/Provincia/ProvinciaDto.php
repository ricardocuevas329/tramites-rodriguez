<?php

namespace App\Dtos\Provincia;

use App\Http\Requests\Mantenimiento\Provincia\StoreProvinciaRequest;
use App\Http\Requests\Mantenimiento\Provincia\UpdateProvinciaRequest;

class ProvinciaDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_provincia,
    ){}
        
        public static function fromApiRequest(StoreProvinciaRequest|UpdateProvinciaRequest  $request): ProvinciaDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_provincia: $request->validated('s_provincia'),
    );
}

}