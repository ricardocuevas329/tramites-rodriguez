<?php

namespace App\Dtos\ModoPago;

use App\Http\Requests\Mantenimiento\ModoPago\StoreModoPagoRequest;
use App\Http\Requests\Mantenimiento\ModoPago\UpdateModoPagoRequest;

class ModoPagoDto
{
    public function __construct(
      public readonly ?string $s_codigo_pdt,
      public readonly ?string $s_codigo_sbs,
      public readonly ?string $s_nombre,
      public readonly ?string $s_descripcion,
    ){}

        public static function fromApiRequest(StoreModoPagoRequest|UpdateModoPagoRequest  $request): ModoPagoDto
        {
            return new self(
            s_codigo_pdt: $request->validated('s_codigo_pdt'),
            s_codigo_sbs: $request->validated('s_codigo_sbs'),
            s_nombre: $request->validated('s_nombre'),
            s_descripcion: $request->validated('s_descripcion'),
    );
}

}
