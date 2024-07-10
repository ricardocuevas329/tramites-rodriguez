<?php

namespace App\Http\Controllers\Protocolar;


use App\Dtos\DetalleProcurador\StoreDetalleProcuradorDto;
use App\Dtos\DetalleProcurador\UpdateDetalleProcuradorDto;
use App\Dtos\Presencias\StorePresenciaDto;
use App\Dtos\Presencias\UpdatePresenciaDto;
use App\Enums\ProcuradorDocumentsTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\Presencia\StorePresenciaRequest;
use App\Http\Requests\Protocolar\Presencia\UpdatePresenciaRequest;
use App\Models\Protocolar\Presencia;
use App\Services\Protocolar\DetalleProcuradorDocumentService;
use App\Services\Protocolar\DetalleProcuradorService;
use App\Services\Protocolar\ProcuradorService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ProcuradorController extends Controller
{

    use ApiResponser;

    protected array $permissions = [];


    public function __construct(
        protected ProcuradorService                $service,
        protected DetalleProcuradorService         $detalleProcuradorService,
        protected DetalleProcuradorDocumentService $detalleProcuradorDocumentService

    )
    {

    }

    public function list(Request $request): JsonResource
    {
        return $this->service->get($request);
    }

    public function store(StorePresenciaRequest $request): JsonResponse
    {
        $data = $this->service->store(
            StorePresenciaDto::fromApiRequest($request)
        );
        return $this->success($data, 'Bien Hecho, Presencia Notarial Guardada correctamente!');
    }

    public function update(UpdatePresenciaRequest $request, Presencia $payload): JsonResponse
    {

        $data = $this->service->update(
            $payload,
            UpdatePresenciaDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Kardex Se actualizó correctamente!");
    }


    public function findById(string $id): JsonResponse
    {

        $data = $this->service->findById($id);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos");

    }

    public function saveInit(string $id): JsonResponse
    {
        $dp = $this->detalleProcuradorService->finByIdPresencia($id);
        if (!$dp) {
            $data = $this->detalleProcuradorService->store(new StoreDetalleProcuradorDto(
                s_date_inicio: date('Y-m-d H:i:s'),
                s_presencia: $id,
            ));
            if ($data) {
                return $this->success($this->service->findById($id), "Iniciado Correctamente!");
            }
        } else {
            return $this->error("Ya ha sido Iniciado!");
        }
        return $this->error("Ocurrio un error!");

    }

    public function saveFinish(string $id): JsonResponse
    {

        $dp = $this->detalleProcuradorService->finByIdPresencia($id);
        if ($dp) {
            $data = $this->detalleProcuradorService->update($dp,
                new UpdateDetalleProcuradorDto(
                    s_date_fin: date('Y-m-d H:i:s'),
                ));
            if ($data) {
                return $this->success($this->service->findById($id), "Iniciado Correctamente!");
            }

        }
        return $this->error("Ocurrio un error!");

    }

    public function initUploadDocuments(string $id, Request $request): JsonResponse
    {

        $documents = (array) $request->documents;
        if (count($documents)) {
            $dp = $this->detalleProcuradorService->finByIdPresencia($id);
            if ($dp) {
                $data = $this->detalleProcuradorDocumentService->saveMany($documents, $dp->id, ProcuradorDocumentsTypes::INIT->value);
                if ($data) {
                    return $this->success($this->service->findById($id), "Documento Guardado Correctamente!");
                }
            } else {
                return $this->error("Primero dale en Iniciar");
            }

        } else {
            return $this->error("Agregue Archivos!");
        }

        return $this->error("Intentelo Nuevamente!");
    }

    public function finishUploadDocuments(string $id, Request $request): JsonResponse
    {

        $documents = (array) $request->documents;
        if (count($documents)) {
            $dp = $this->detalleProcuradorService->finByIdPresencia($id);
            if ($dp) {
                $data = $this->detalleProcuradorDocumentService->saveMany($documents, $dp->id, ProcuradorDocumentsTypes::FINISH->value);
                if ($data) {
                    return $this->success($this->service->findById($id), "Documento Guardado Correctamente!");
                }
            } else {
                return $this->error("Primero dale en Iniciar");
            }

        } else {
            return $this->error("Agregue Archivos!");
        }

        return $this->error("Intentelo Nuevamente!");

    }


}
