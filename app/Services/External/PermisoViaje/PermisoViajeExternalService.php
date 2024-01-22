<?php

namespace App\Services\External\PermisoViaje;

use App\Dtos\PermisoViajeDocument\PermisoViajeDocumentDto;
use App\Dtos\PermisoViajeExternal\PermisoViajeExternalDto;
use App\Dtos\PermisoViajeParticipantExternal\PermisoViajeParticipantExternalDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\External\Extraprotocolar\PermisoViajeExternal;
use App\Services\External\Participant\ParticipantExternalService;
use App\Services\ExtraProtocolar\PermisoViajeDocumentService;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentPermisoViaje;
use App\Traits\UploadFileStorage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermisoViajeExternalService extends Controller
{

    use GenerateDocumentPermisoViaje, UploadFileStorage;

    public function __construct(
        protected ParticipantExternalService  $participantExternalService,
        protected PermisoViajeDocumentService $permisoViajeDocumentService
    )
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $data =  PermisoViajeExternal::MyRecords()->orderBy('id','desc')->with(['participantes'])->paginate(5);
        return CollectionResource::collection($data);
    }

    public function store(PermisoViajeExternalDto $dto): PermisoViajeExternal
    {

        $permisoViaje = new PermisoViajeExternal( $dto->toArray());
        $permisoViaje->save();
        $participants = $dto->participantes;


        if (count($participants)) {
            foreach ($participants as $key => $value) {
                $jsonValue = json_encode($value);

                $participant = json_decode($jsonValue);

                $files = $participant->files;

                $participantSaved = $this->participantExternalService->store(
                    new PermisoViajeParticipantExternalDto(
                        name: $participant->nombre,
                        type: $participant->rol,
                        id_permiso_viaje: $permisoViaje->id,
                    )
                );

                if (count($files)) {
                    foreach ($files as $file => $value) {
                        if (isset($value->base64)) {
                            $folder = 'permiso-via-doc-ext-';
                             $this->permisoViajeDocumentService->store(
                                new PermisoViajeDocumentDto(
                                    id_permiso_viaje: $permisoViaje->id,
                                    file: $this->UploadFilesS3($value->base64, $folder, $value->type),
                                    name: $value->name,
                                    type: $value->type,
                                    size: $value->size,
                                    id_participant: $participantSaved->id
                                )
                            );
                        }
                    }
                }

            }
        }

        return $permisoViaje;
    }


}
