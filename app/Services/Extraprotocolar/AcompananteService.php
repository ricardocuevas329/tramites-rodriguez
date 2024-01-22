<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\Acompanante\AcompananteDto;
use App\Dtos\Cliente\ClienteDto;
use App\Dtos\Participante\ParticipanteDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Cliente;
use App\Models\ExtraProtocolar\Participante;
use App\Services\Entidad\ClienteService;
use Illuminate\Http\Request;

class AcompananteService extends Controller
{

    public function __construct(
        protected ClienteService $clienteService,

    )
    {
    }



    public function store(AcompananteDto $dto): Participante
    {
        return Participante::create($dto->toArray());
    }

    public function findById(Participante $Participante): Participante
    {
        return $Participante;
    }


    public function disabled(Participante $Participante): Participante
    {
        return tap($Participante)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Participante $Participante): Participante
    {
        return tap($Participante)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Participante $Participante): Participante
    {
        return tap($Participante)->delete();
    }
}
