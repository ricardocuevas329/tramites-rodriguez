<?php

namespace App\Dtos\DiligenciaProgramada;

use App\Http\Requests\ExtraProtocolar\DiligenciaProgramada\StoreDiligenciaProgramadaRequest;
use App\Http\Requests\ExtraProtocolar\DiligenciaProgramada\UpdateDiligenciaProgramadaRequest;

class DiligenciaProgramadaDto
{
    public function __construct(
        public readonly ?string $d_fecha_programacion,
        public readonly ?int    $s_num_carta,
        public readonly ?string $s_motorizado,
        public readonly ?string $s_observacion,
    )
    {
    }

    public function toArray()
    {
        return [
            'd_fecha_programacion' => $this->d_fecha_programacion,
            's_num_carta' => $this->s_num_carta,
            's_observacion' => $this->s_observacion,
        ];
    }

    public static function fromApiRequest(StoreDiligenciaProgramadaRequest|UpdateDiligenciaProgramadaRequest $request): DiligenciaProgramadaDto
    {
        return new self(
            d_fecha_programacion: $request->validated('d_fecha_programacion'),
            s_num_carta: $request->validated('s_num_carta'),
            s_motorizado: $request->validated('s_motorizado'),
            s_observacion: $request->validated('s_observacion'),
        );
    }

}
