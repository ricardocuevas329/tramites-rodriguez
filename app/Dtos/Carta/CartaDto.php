<?php

namespace App\Dtos\Carta;

use App\Http\Requests\ExtraProtocolar\Carta\StoreCartaRequest;
use App\Http\Requests\ExtraProtocolar\Carta\UpdateCartaRequest;

class CartaDto
{
    public function __construct(
        public readonly ?string $s_remitente,
        public readonly ?string $s_referente,
        public readonly ?string $s_facturado,
        public readonly ?array $destinatarios = [],
        public readonly ?string $s_observacion,
        public readonly ?Int $i_tipopago,
        public readonly ?Int $i_delivery,
        public readonly ?Int $i_bajopuerta,
        public readonly ?Int $i_urgente,
        public readonly ?array $formRemitente,
        public readonly ?string $facturado_correo,
        public readonly ?string $facturado_telefono,

    ) {
    }
    public function toArray()
    {
        return [
            's_remitente' => $this->s_remitente,
            's_empresa' => $this->s_referente,
            's_facturado' => $this->s_facturado,
            'destinatarios' => $this->destinatarios,
            's_observacion' => $this->s_observacion,
            'i_tipopago' => $this->i_tipopago,
            'i_delivery' => $this->i_delivery,
            'i_bajopuerta' => $this->i_bajopuerta,
            'i_urgente' => $this->i_urgente,
            'facturado_correo' => $this->facturado_correo,
            'facturado_telefono' => $this->facturado_telefono,
        ];
    }

    public static function fromApiRequest(StoreCartaRequest|UpdateCartaRequest  $request): CartaDto
    {
        return new self(
            s_remitente: $request->validated('s_remitente'),
            s_referente: $request->validated('s_referente'),
            s_facturado: $request->validated('s_facturado'),
            destinatarios: $request->validated('destinatarios'),
            s_observacion: $request->validated('s_observacion'),
            i_tipopago: $request->validated('i_tipopago'),
            i_delivery: $request->validated('i_delivery'),
            i_bajopuerta: $request->validated('i_bajopuerta'),
            i_urgente: $request->validated('i_urgente'),
            formRemitente: $request->validated('formRemitente'),
            facturado_correo: $request->validated('facturado_correo'),
            facturado_telefono: $request->validated('facturado_telefono'),
        );
    }
}
