<?php

namespace App\Dtos\Firma;
use App\Http\Requests\ExtraProtocolar\Firma\StoreRegistroFirmaRequest;
use App\Http\Requests\ExtraProtocolar\Firma\UpdateRegistroFirmaRequest;

class StoreFirmaDto
{
    public function __construct(
        public readonly ?string $d_caducidad,
        public readonly ?string $s_cliente,
        public readonly ?string $s_proceder,
        public readonly ?array $files = [],
    )
    {
    }

    public function toArray()
    {
        return [
            'd_caducidad' => $this->d_caducidad,
            's_cliente' => $this->s_cliente,
            's_proceder' => $this->s_proceder,
            'files' => $this->files,
        ];
    }

    public static function fromApiRequest(StoreRegistroFirmaRequest|UpdateRegistroFirmaRequest $request): StoreFirmaDto
    {
        return new self(
            d_caducidad: $request->validated('d_caducidad'),
            s_cliente: $request->validated('s_cliente'),
            s_proceder: $request->validated('s_proceder'),
            files: $request->validated('files'),
        );
    }

}
