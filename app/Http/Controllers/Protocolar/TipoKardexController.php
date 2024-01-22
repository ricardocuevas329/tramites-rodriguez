<?php

namespace App\Http\Controllers\Protocolar;

use App\Dtos\Kardex\StoreKardexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\StoreKardexRequest;
use App\Http\Requests\Protocolar\UpdateKardexRequest;
use App\Models\Protocolar\Kardex;
use App\Services\ExtraProtocolar\PermisoViajeDocumentService;
use App\Services\Protocolar\KardexService;
use App\Services\Protocolar\TipoKardexService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class TipoKardexController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];


    public function __construct(
        protected TipoKardexService         $service,
        protected PermisoViajeDocumentService $permisoViajeDocumentService
    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function listActives(): JsonResource
    {
        return $this->service->getActives();
    }


    public function list(Request $request): JsonResource
    {
        $this->verifyPermission($this->permissions, 'Listar Kardex');
        return $this->service->get($request);
    }


    public function store(StoreKardexRequest $request): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Crear Kardex');

        $data = $this->service->store(
            StoreKardexDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateKardexRequest $request, Kardex $kardex): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar Kardex');

        $data = $this->service->update(
            $kardex,
            StoreKardexDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Kardex $kardex): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Actualizar Kardex');
        $data = $this->service->findById($kardex);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Kardex $kardex): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Desactivar Kardex');
        $data = $this->service->disabled($kardex);
        return $this->success($data, "Desactivado Correctamente!");
    }

    public function enabled(Kardex $kardex): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Activar Kardex');
        $data = $this->service->enabled($kardex);
        return $this->success($data, "Activado Correctamente!");
    }




}
