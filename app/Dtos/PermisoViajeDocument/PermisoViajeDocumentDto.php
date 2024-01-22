<?php

namespace App\Dtos\PermisoViajeDocument;
class PermisoViajeDocumentDto
{
    public function __construct(
        public readonly ?string $id_permiso_viaje,
        public readonly ?string $file,
        public readonly ?string $name,
        public readonly ?string $type,
        public readonly ?string $size,
        public readonly ?int $id_participant = 0

    )
    {
    }

    public function toArray(): array
    {
        return [
            'id_permiso_viaje' => $this->id_permiso_viaje,
            'file' => $this->file,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'id_participant' => $this->id_participant,
        ];
    }

}
