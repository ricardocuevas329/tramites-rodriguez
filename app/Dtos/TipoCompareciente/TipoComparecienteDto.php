<?php

namespace App\Dtos\TipoCompareciente;

use App\Http\Requests\Mantenimiento\TipoCompareciente\StoreTipoComparecienteRequest;
use App\Http\Requests\Mantenimiento\TipoCompareciente\UpdateTipoComparecienteRequest;

class TipoComparecienteDto
{
    public function __construct(
      public readonly ?string $s_clase,
      public readonly ?string $s_codigo_sg,
      public readonly ?string $s_color,
      public readonly ?string $s_nombre,
      public readonly ?string $s_tipo_pdt,
    ){}

        public static function fromApiRequest(StoreTipoComparecienteRequest|UpdateTipoComparecienteRequest  $request): TipoComparecienteDto
        {
            return new self(
            s_clase: $request->validated('s_clase'),
            s_codigo_sg: $request->validated('s_codigo_sg'),
            s_color: $request->validated('s_color'),
            s_nombre: $request->validated('s_nombre'),
            s_tipo_pdt: $request->validated('s_tipo_pdt'),
    );
}

}
