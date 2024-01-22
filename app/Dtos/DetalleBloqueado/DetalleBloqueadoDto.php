<?php

namespace App\Dtos\DetalleBloqueado;

use App\Http\Requests\Mantenimiento\DetalleBloqueado\StoreDetalleBloqueadoRequest;
use App\Http\Requests\Mantenimiento\DetalleBloqueado\UpdateDetalleBloqueadoRequest;

class DetalleBloqueadoDto
{
    public function __construct(
        public readonly ?string $s_codreg_bloq,
        public readonly ?string $s_compareciente,
        public readonly ?string $s_nombres,
        public readonly ?string $s_paterno,
        public readonly ?string $s_materno,
    ) {
    }
    public function toArray()
    {
        return [
            's_codreg_bloq' => $this->s_codreg_bloq,
            's_compareciente' => $this->s_compareciente,
            's_nombres' => $this->s_nombres,
            's_paterno' => $this->s_paterno,
            's_materno' => $this->s_materno,
        ];
    }

    public static function fromApiRequest(StoreDetalleBloqueadoRequest|UpdateDetalleBloqueadoRequest  $request): DetalleBloqueadoDto
    {
        return new self(
            s_codreg_bloq: $request->validated('s_codreg_bloq'),
            s_compareciente: $request->validated('s_compareciente'),
            s_nombres: $request->validated('s_nombres'),
            s_paterno: $request->validated('s_paterno'),
            s_materno: $request->validated('s_materno'),
        );
    }
}
