<?php

namespace App\Dtos\Firma;
use App\Http\Requests\ExtraProtocolar\Firma\StoreStoreFirmaUploadRequest;

class StoreFirmaUploadDto
{
    public function __construct(
        public readonly ?string $foto_firma,
    )
    {
    }

    public function toArray()
    {
        return [

            'foto_firma' => $this->foto_firma,
        ];
    }

    public static function fromApiRequest(StoreStoreFirmaUploadRequest $request): StoreFirmaUploadDto
    {
        return new self(
            foto_firma: $request->validated('foto_firma'),
        );
    }

}
