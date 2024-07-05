<?php

namespace App\Dtos\DetallePresencias;
class StoreDetallePresenciaDto
{
    public function __construct(

        public readonly ?string $s_referencia,
        public readonly ?string $s_actonotarial,
        public readonly ?string $s_descripcion,
        public readonly ?string $s_hora_inicio,
        public readonly ?string $s_hora_fin,
        public readonly ?string $d_fechapresen,
        public readonly ?string $s_asitente,
        public readonly ?string $s_observacion,
    )
    {
    }

    public function toArray()
    {
        return [
            's_referencia' => $this->s_referencia,
            's_actonotarial' => $this->s_actonotarial,
            's_descripcion' => $this->s_descripcion,
            's_hora_inicio' => $this->s_hora_inicio,
            's_hora_fin' => $this->s_hora_fin,
            'd_fechapresen' => $this->d_fechapresen,
            's_asitente' => $this->s_asitente,
            's_observacion' => $this->s_observacion,
        ];
    }


}
