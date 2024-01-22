<?php

namespace App\Dtos\Acompanante;

use App\Http\Requests\ExtraProtocolar\Participante\StoreParticipanteRequest;
use App\Http\Requests\ExtraProtocolar\Participante\UpdateParticipanteRequest;

class AcompananteDto
{
    public function __construct(
        public readonly ?int    $i_condicion ,
        public readonly ?int    $i_permiso ,
        public readonly ?string $s_participante = '' ,


    )
    {
    }

    public function toArray(): array
    {
        return [
            'i_permiso' => $this->i_permiso ,
            'i_condicion' => $this->i_condicion ,
            's_participante' => $this->s_participante ,
        ];
    }

}
