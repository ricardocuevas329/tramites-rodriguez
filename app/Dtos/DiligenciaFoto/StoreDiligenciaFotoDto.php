<?php

namespace App\Dtos\DiligenciaFoto;

class StoreDiligenciaFotoDto
{
    public function __construct(
        public readonly ?Int $i_diligencia_carta,
        public readonly ?Int $i_size,
        public readonly ?string $s_foto,
        public readonly ?string $s_name,
        public readonly ?string $s_type,
    ) {
    }
    public function toArray()
    {
        return [
            'i_diligencia_carta' => $this->i_diligencia_carta,
            'i_size' => $this->i_size,
            's_foto' => $this->s_foto,
            's_name' => $this->s_name,
            's_type' => $this->s_type,
        ];
    }
}
