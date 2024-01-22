<?php

namespace App\Dtos\Bien;

use App\Http\Requests\Administracion\Bien\StoreBienRequest;
use App\Http\Requests\Administracion\Bien\UpdateBienRequest;

class BienDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_nombre,
      public readonly ?string $s_decripcion,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreBienRequest|UpdateBienRequest  $request): BienDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_nombre: $request->validated('s_nombre'),
            s_decripcion: $request->validated('s_decripcion'),
            i_estado: $request->validated('i_estado'),
    );
}

}