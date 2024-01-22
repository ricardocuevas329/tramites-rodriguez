<?php

namespace App\Services\External\Participant;

use App\Dtos\PermisoViajeParticipantExternal\PermisoViajeParticipantExternalDto;
use App\Models\External\Extraprotocolar\PermisoViajeParticipantExternal;


class ParticipantExternalService
{

    public function store(PermisoViajeParticipantExternalDto $dto): PermisoViajeParticipantExternal
    {
        return PermisoViajeParticipantExternal::create($dto->toArray());
    }

}
