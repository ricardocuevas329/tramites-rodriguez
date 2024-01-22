<?php

namespace App\Dtos\FirmaDocument;
class StoreFirmaDocumentDto
{
    public function __construct(

        public readonly ?string $id_firma,
        public readonly ?string $file,
        public readonly ?string $name,
        public readonly ?string $type,
        public readonly ?int    $size,

    )
    {
    }

    public function toArray()
    {
        return [

            'id_firma' => $this->id_firma,
            'file' => $this->file,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,

        ];
    }


}
