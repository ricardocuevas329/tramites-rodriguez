<?php

namespace App\Dtos\Presencias;

use App\Http\Requests\Protocolar\Presencia\StorePresenciaRequest;

class StorePresenciaDto
{
    public function __construct(


        public readonly ?string $s_contacto,
        public readonly ?string $s_facturado,
        public readonly ?string $s_referente,
        public readonly array $details = [],
    )
    {
    }

    public function toArray()
    {
        return [
            's_contacto' => $this->s_contacto,
            's_facturado' => $this->s_facturado,
            's_referente' => $this->s_referente,
        ];
    }

    public static function fromApiRequest(StorePresenciaRequest $request): StorePresenciaDto
    {
        return new self(
            s_contacto: $request->validated('contacto'),
            s_facturado: $request->validated('solicitante'),
            s_referente: $request->validated('empresa'),
            details: $request->validated('details'),
        );
    }

}
