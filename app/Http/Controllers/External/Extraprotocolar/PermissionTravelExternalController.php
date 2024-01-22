<?php

namespace App\Http\Controllers\External\Extraprotocolar;

use App\Dtos\PermisoViajeExternal\PermisoViajeExternalDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\External\PermisoViajeExternal\StorePermisoViajeExternalRequest;
use App\Http\Resources\CollectionResource;
use App\Services\Entidad\ClienteService;
use App\Services\External\PermisoViaje\PermisoViajeExternalService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionTravelExternalController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    public function __construct(
        protected PermisoViajeExternalService $service,
        protected ClienteService $clienteService
    ) {

    }

    public function myRecords(Request $request)
    {
        return $this->service->get($request);
    }


    public function findByDocument(Request $request)
    {

        $cliente = $this->clienteService->findByDocument($request);
        if ($cliente) {
            return $this->success($cliente);
        }
        return $this->error("No se encontraron datos", 422);
    }


    public function store(StorePermisoViajeExternalRequest $request): JsonResponse
    {

        if (count($request->get('participantes')) == 0) {
            return $this->error( "Seleccione al menos 1 Participante!");
        }

        $data = $this->service->store(
            PermisoViajeExternalDto::fromApiRequest($request)
        );
        return $this->success($data, 'Permiso de Viaje Generado correctamente!');
    }




}
