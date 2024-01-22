<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\Participante\ParticipanteDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\Participante\UpdateParticipanteRequest;
use App\Models\ExtraProtocolar\Participante;
use App\Services\Extraprotocolar\ParticipanteService;
use App\Traits\ApiResponser;


class ParticipantController extends Controller
{

    use ApiResponser;
    public function __construct(
        protected ParticipanteService $service
    ) {
    }


    public function update(UpdateParticipanteRequest $request, Participante $participant)
    {

        $data = $this->service->update(
            $participant,
            ParticipanteDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function destroy(Participante $participant)
    {

        $data =  $this->service->destroy($participant);
        if ($data) {
         return $this->success($data, "Eliminado Correctamente!");
        }

    }



}
