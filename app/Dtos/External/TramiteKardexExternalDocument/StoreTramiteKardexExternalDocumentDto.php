<?php

namespace App\Dtos\External\TramiteKardexExternalDocument;

use App\Dtos\TramiteKardexExternalDocument\StoreStoreTramiteKardexExternalDocumentRequest;
use App\Dtos\TramiteKardexExternalDocument\UpdateStoreTramiteKardexExternalDocumentRequest;

class StoreTramiteKardexExternalDocumentDto
{
    public function __construct(

        public readonly ?int    $id_kardex = 0,
        public readonly ?string $file,
        public readonly ?string $tipo_archivo,
        public readonly ?string $name,
        public readonly ?string $type,
        public readonly ?int    $size = 0,

    )
    {
    }

    public function toArray()
    {
        return [
            'id_kardex' => $this->id_kardex,
            'file' => $this->file,
            'tipo_archivo' => $this->tipo_archivo,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
        ];
    }


}
