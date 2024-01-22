<?php

namespace App\Dtos\DiligenciaCarta;

use App\Http\Requests\ExtraProtocolar\DiligenciaCarta\StoreDiligenciaCartaRequest;
use App\Http\Requests\ExtraProtocolar\DiligenciaCarta\UpdateDiligenciaCartaRequest;

class DiligenciaCartaDto
{
    public function __construct(
        public readonly ?string $inmueble,
        public readonly ?string $s_color,
        public readonly ?Int $s_num_carta,
        public readonly ?string $s_observacion,
        public readonly ?string $s_pisos,
        public readonly ?string $s_proyeccion,
        public readonly ?string $s_puertas,
        public readonly ?string $s_recibido_dni,
        public readonly ?string $s_recibido_por,
        public readonly ?string $s_relacion_destinatario,
        public readonly ?string $s_ventanas,
        public readonly ?array $fotos = [],
    ) {
    }
    public function toArray()
    {
        return [

            'inmueble' => $this->inmueble,
            's_color' => $this->s_color,
            's_num_carta' => $this->s_num_carta,
            's_observacion' => $this->s_observacion,
            's_pisos' => $this->s_pisos,
            's_proyeccion' => $this->s_proyeccion,
            's_puertas' => $this->s_puertas,
            's_recibido_dni' => $this->s_recibido_dni,
            's_recibido_por' => $this->s_recibido_por,
            's_relacion_destinatario' => $this->s_relacion_destinatario,
            's_ventanas' => $this->s_ventanas,
            'fotos' => $this->fotos,
        ];
    }

    public static function fromApiRequest(StoreDiligenciaCartaRequest|UpdateDiligenciaCartaRequest  $request): DiligenciaCartaDto
    {
        return new self(
            inmueble: $request->validated('inmueble'),
            s_color: $request->validated('s_color'),
            s_num_carta: $request->validated('s_num_carta'),
            s_observacion: $request->validated('s_observacion'),
            s_pisos: $request->validated('s_pisos'),
            s_proyeccion: $request->validated('s_proyeccion'),
            s_puertas: $request->validated('s_puertas'),
            s_recibido_dni: $request->validated('s_recibido_dni'),
            s_recibido_por: $request->validated('s_recibido_por'),
            s_relacion_destinatario: $request->validated('s_relacion_destinatario'),
            s_ventanas: $request->validated('s_ventanas'),
            fotos: $request->validated('fotos'),
        );
    }
}
