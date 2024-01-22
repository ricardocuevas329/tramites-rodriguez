<?php

namespace App\Http\Controllers\External\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\External\Kardex\SearchKardexRequest;
use App\Http\Requests\External\Kardex\StoreKardexAsignationRequest;
use App\Services\External\Protocolar\KardexService;
use App\Services\External\Protocolar\TramiteKardexExternalDocumentService;
use App\Services\Protocolar\TipoKardexService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class KardexController extends Controller
{
    use ApiResponser;


    public function __construct(
        protected TipoKardexService $tipoKardexService,
        protected KardexService     $kardexService,
        protected TramiteKardexExternalDocumentService $tramiteKardexExternalDocumentService
    )
    {

    }


    public function searchKardex(SearchKardexRequest $request): JsonResource
    {
        return $this->kardexService->getKardex($request);
    }

    public function listActives(): JsonResource
    {
        return $this->tipoKardexService->getActives();
    }


    public function listParticipants(Request $request)
    {
        $kardex = $request->kardex;
        return $this->kardexService->getParticipants($kardex);
    }

    public function saveAsignation(StoreKardexAsignationRequest $request)
    {
        if (!$this->kardexService->existsKardex($request)) {
            return $this->error("Kardex no Existe!!");
        }

        $data = $this->kardexService->saveAsignation($request);
        return $this->success($data, "Kardex Asigando Correctamente!!");
    }


    public function saveDocument(Request $request)
    {

        $documents = $request->documents;
        $id_kardex = (int) $request->id_kardex;

        if (!count($documents)) {
            return $this->error("Agregue Documentos");
        }

        $data = $this->tramiteKardexExternalDocumentService->saveMany($documents, $id_kardex);
        if($data){
            return $this->success($data, "Documento Guardado Correctamente!!");
        }
        return $this->error($data, "Ocurrió algo , Intentelo Nuevamente!!");
    }

}
