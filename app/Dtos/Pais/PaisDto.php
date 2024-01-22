<?php

namespace App\Dtos\Pais;

use App\Http\Requests\Mantenimiento\Pais\StorePaisRequest;
use App\Http\Requests\Mantenimiento\Pais\UpdatePaisRequest;

class PaisDto
{
    public function __construct(
      public readonly ?string $s_gentilicio_f,
      public readonly ?string $s_gentilicio_m,
      public readonly ?string $s_pais,
    ){}
        
        public static function fromApiRequest(StorePaisRequest|UpdatePaisRequest  $request): PaisDto
        {
            return new self(
            s_gentilicio_f: $request->validated('s_gentilicio_f'),
            s_gentilicio_m: $request->validated('s_gentilicio_m'),
            s_pais: $request->validated('s_pais'),
    );
}

}