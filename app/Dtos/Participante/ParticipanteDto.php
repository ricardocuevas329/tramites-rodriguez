<?php

namespace App\Dtos\Participante;

use App\Http\Requests\ExtraProtocolar\Participante\StoreParticipanteRequest;
use App\Http\Requests\ExtraProtocolar\Participante\UpdateParticipanteRequest;

class ParticipanteDto
{
    public function __construct(
        public readonly ?int    $i_condicion ,
        public readonly ?int    $i_firma ,
        public readonly ?int    $i_permiso = 0 ,
        public readonly ?string $s_edad ,
        public readonly ?string $s_observacion = '' ,
        public readonly ?string $s_participante = '' ,
        public readonly ?string $s_partida ,
        public readonly ?string $s_sede_reg ,
        public readonly ?array  $cliente = [] ,

    )
    {
    }

    public function toArray(): array
    {
        return [
            'i_condicion' => $this->i_condicion ,
            'i_firma' => $this->i_firma ,
            'i_permiso' => $this->i_permiso ,
            's_edad' => $this->s_edad ,
            's_observacion' => $this->s_observacion ,
            's_participante' => $this->s_participante ,
            's_partida' => $this->s_partida ,
            's_sede_reg' => $this->s_sede_reg ,
            'cliente' => $this->cliente ,
        ];
    }

    public static function fromApiRequest(StoreParticipanteRequest|UpdateParticipanteRequest $request): ParticipanteDto
    {
        return new self(
            i_condicion: $request->validated('i_condicion') ,
            i_firma: $request->validated('i_firma') ,
            i_permiso: $request->validated('i_permiso') ,
            s_edad: $request->validated('s_edad') ,
            s_observacion: $request->validated('s_observacion') ,
            s_participante: $request->validated('s_participante') ,
            s_partida: $request->validated('s_partida') ,
            s_sede_reg: $request->validated('s_sede_reg') ,
            cliente: $request->validated('cliente') ,

        );
    }
}
