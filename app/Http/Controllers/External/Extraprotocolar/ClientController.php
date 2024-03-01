<?php

namespace App\Http\Controllers\External\Extraprotocolar;

use App\Dtos\External\Client\StoreClientDto;
use App\Dtos\PermisoViajeExternal\PermisoViajeExternalDto;
use App\Models\External\Protocolar\TramiteKardexExternalDocument;
use App\Http\Controllers\Controller;
use App\Http\Requests\External\Client\StoreClientRequest;
use App\Services\External\Protocolar\ClientService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ClientController extends Controller
{
    use ApiResponser, MiddlewarePermission;

    public function __construct(
        protected ClientService $service,
    ) {
    }

    public function list(Request $request): JsonResource
    {
        return $this->service->get($request);
    }

    public function listCLiente(Request $request): JsonResource
    {
        return $this->service->getCliente($request);
    }

    public function listRegisterPublics(Request $request)
    {
        $id = $request->id;
        return $this->success($this->service->getRegisterPublics($id));
    }

    public function estadoClic(Request $request)
    {
        $id = $request->id;
        // Actualizar el campo estado_clic a true
        TramiteKardexExternalDocument::where('id', $id)
            ->update(['estado_clic' => true]);
        // Opcionalmente, puedes devolver una respuesta o redireccionar a otra página
        return response()->json(['message' => 'Campo estado_clic actualizado correctamente']);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $documents = $request->documents;
        if (!count($documents)) {
            return $this->error('Agregue Documentos!!');
        }
        $data = $this->service->store(
            StoreClientDto::fromApiRequest($request)
        );
        return $this->success($data, 'Información Grabada correctamente!');
    }
}
