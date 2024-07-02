<?php

namespace App\Dtos\Presencias;

use App\Http\Requests\Protocolar\Presencia\StorePresenciaRequest;

class StorePresenciaDto
{
    public function __construct(

        public readonly ?int    $i_tipopago,
        public readonly ?string $s_contacto,
        public readonly ?string $s_facturado,
        public readonly ?string $s_observacion,
        public readonly ?string $s_referente,
    )
    {
    }

    public function toArray()
    {
        return [

            'i_tipopago' => $this->i_tipopago,
            's_contacto' => $this->s_contacto,
            's_facturado' => $this->s_facturado,
            's_observacion' => $this->s_observacion,
            's_referente' => $this->s_referente,
        ];
    }

    public static function fromApiRequest(StorePresenciaRequest $request): StorePresenciaDto
    {
        return new self(
            i_tipopago: $request->validated('i_tipopago'),
            s_contacto: $request->validated('s_contacto'),
            s_facturado: $request->validated('s_facturado'),
            s_observacion: $request->validated('s_observacion'),
            s_referente: $request->validated('s_referente'),
        );
    }

}
