<?php

namespace App\Dtos\PermisoViajeParticipantExternal;
class PermisoViajeParticipantExternalDto
{
    public function __construct(

        public readonly ?string $name ,
        public readonly ?int $type ,
        public readonly ?int $id_permiso_viaje,

    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name ,
            'type' => $this->type ,
            'id_permiso_viaje' => $this->id_permiso_viaje ,
        ];
    }


}
