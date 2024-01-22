<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\Cliente\ClienteDto;
use App\Dtos\Participante\ParticipanteDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Cliente;
use App\Models\ExtraProtocolar\Participante;
use App\Services\Entidad\ClienteService;
use Illuminate\Http\Request;

class ParticipanteService extends Controller
{

    public function __construct(
        protected ClienteService $clienteService,

    )
    {
    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Participante::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('i_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(ParticipanteDto $dto): Participante
    {
        return Participante::create($dto->toArray());
    }

    public function update(Participante $Participante, ParticipanteDto $dto)
    {

        $jsonValue = json_encode($dto);
        $item = json_decode($jsonValue);
        $payload = $item->cliente;

        $isUpdated = $Participante->update([
            'i_firma' => $dto->i_firma,
            'i_condicion' => $dto->i_condicion,
            's_edad' => $dto->s_edad,
            's_observacion' => $dto->s_observacion,
            's_partida' => $dto->s_partida,
            's_sede_reg' => $dto->s_sede_reg,
        ]);

        if ($isUpdated) {

            $cliente = Cliente::find($payload->s_codigo);
            $this->clienteService->update(
                $cliente,
                new ClienteDto(
                    s_paterno: $payload->s_paterno,
                    s_materno: $payload->s_materno,
                    s_nombres: $payload->s_nombres,
                    s_num_doc: $payload->s_num_doc,
                    d_fecha_nac: $payload->d_fecha_nac,
                    s_estado_civil: $payload->s_estado_civil,
                    s_nacionalidad: $payload->s_nacionalidad,
                    s_localidad: $payload->s_localidad,
                    s_direccion: $payload->s_direccion,
                    s_sexo: $payload->s_sexo,
                    //s_correo: $payload->s_correo,
                    id_tipo_documento: $payload->id_tipo_documento,
                    s_tipoDocu: $payload->id_tipo_documento
                )
            );

            return Participante::where('s_participante', $Participante->s_participante)->with('cliente')->first();
        }
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
        return $this->disabled($Participante);
    }
}
