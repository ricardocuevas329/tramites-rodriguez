<?php

namespace App\Dtos\TipoDocumento;

use App\Http\Requests\Mantenimiento\TipoDocumento\StoreTipoDocumentoRequest;
use App\Http\Requests\Mantenimiento\TipoDocumento\UpdateTipoDocumentoRequest;

class TipoDocumentoDto
{
    public function __construct(
       public readonly ?string $s_codigo,
      public readonly ?string $s_nombre,
      public readonly ?string $s_descripcion,
      public readonly ?Int $i_estado,
    ){}
        
        public static function fromApiRequest(StoreTipoDocumentoRequest|UpdateTipoDocumentoRequest  $request): TipoDocumentoDto
        {
            return new self(
            s_codigo: $request->validated('s_codigo'),
            s_nombre: $request->validated('s_nombre'),
            s_descripcion: $request->validated('s_descripcion'),
            i_estado: $request->validated('i_estado'),
    );
}

}