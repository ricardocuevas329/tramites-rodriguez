<?php

namespace App\Dtos\Distrito;

use App\Http\Requests\Mantenimiento\Distrito\StoreDistritoRequest;
use App\Http\Requests\Mantenimiento\Distrito\UpdateDistritoRequest;

class DistritoDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_distrito,
    ){}
        
        public static function fromApiRequest(StoreDistritoRequest|UpdateDistritoRequest  $request): DistritoDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_distrito: $request->validated('s_distrito'),
    );
}

}