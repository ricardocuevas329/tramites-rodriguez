<?php

namespace App\Dtos\External\Client;

use App\Http\Requests\External\Client\StoreClientRequest;
use App\Http\Requests\External\Client\UpdateClientRequest;

class StoreClientDto
{
    public function __construct(
        public readonly ?string $numero_documento,
        public readonly ?string $apellido_materno,
        public readonly ?string $nombres,
        public readonly ?string $apellido_paterno,
        public readonly ?string $tipo_documento,
        public readonly ?array  $documents,

    )
    {
    }


    public function toArray()
    {
        return [
            'documento' => $this->numero_documento,
            'materno' => $this->apellido_materno,
            'nombres' => $this->nombres,
            'paterno' => $this->apellido_paterno,
            'tipo_documento' => $this->tipo_documento,
        ];
    }

    public static function fromApiRequest(StoreClientRequest|UpdateClientRequest $request): StoreClientDto
    {
        return new self(
            numero_documento: $request->validated('numero_documento'),
            apellido_materno: $request->validated('apellido_materno'),
            nombres: $request->validated('nombres'),
            apellido_paterno: $request->validated('apellido_paterno'),
            tipo_documento: $request->validated('tipo_documento'),
            documents: $request->validated('documents'),
        );
    }

}
