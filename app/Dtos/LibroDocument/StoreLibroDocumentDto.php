<?php

namespace App\Dtos\LibroDocument;
class StoreLibroDocumentDto
{
    public function __construct(
        public readonly ?string $file,
        public readonly ?string $id_libro,
        public readonly ?string $name,
        public readonly ?int    $size,
        public readonly ?string $type,
    )
    {
    }

    public function toArray()
    {
        return [
            'file' => $this->file,
            'id_libro' => $this->id_libro,
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->type,
        ];
    }

}
