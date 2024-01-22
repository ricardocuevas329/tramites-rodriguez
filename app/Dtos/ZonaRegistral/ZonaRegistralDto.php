<?php

namespace App\Dtos\ZonaRegistral;

use App\Http\Requests\Mantenimiento\ZonaRegistral\StoreZonaRegistralRequest;
use App\Http\Requests\Mantenimiento\ZonaRegistral\UpdateZonaRegistralRequest;

class ZonaRegistralDto
{
    public function __construct(
      public readonly ?string $s_codigo_sbs,
      public readonly ?string $s_nombre,
    ){}
        
        public static function fromApiRequest(StoreZonaRegistralRequest|UpdateZonaRegistralRequest  $request): ZonaRegistralDto
        {
            return new self(
            s_codigo_sbs: $request->validated('s_codigo_sbs'),
            s_nombre: $request->validated('s_nombre'),
    );
}

}