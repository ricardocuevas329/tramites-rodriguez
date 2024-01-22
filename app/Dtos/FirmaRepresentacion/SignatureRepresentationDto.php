<?php

namespace App\Dtos\FirmaRepresentacion;
use App\Http\Requests\ExtraProtocolar\FirmaRepresentacion\StoreStoreFirmaRepresentacionRequest;
use App\Http\Requests\ExtraProtocolar\FirmaRepresentacion\UpdateStoreFirmaRepresentacionRequest;

class SignatureRepresentationDto
{
    public function __construct(
        public readonly ?string $s_representado,
        public readonly ?string $s_cliente,
        public readonly ?string $s_observacion,
    )
    {
    }

    public function toArray()
    {
        return [
            's_representado' => $this->s_representado,
            's_cliente' => $this->s_cliente,
            's_observacion' => $this->s_observacion,
        ];
    }

    public static function fromApiRequest(StoreStoreFirmaRepresentacionRequest|UpdateStoreFirmaRepresentacionRequest $request): SignatureRepresentationDto
    {
        return new self(
            s_representado: $request->validated('s_representado'),
            s_cliente: $request->validated('s_cliente'),
            s_observacion: $request->validated('s_observacion'),
        );
    }

}
