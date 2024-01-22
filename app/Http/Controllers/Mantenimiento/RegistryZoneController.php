<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\ZonaRegistral\ZonaRegistralDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\ZonaRegistral\StoreZonaRegistralRequest;
use App\Http\Requests\Mantenimiento\ZonaRegistral\UpdateZonaRegistralRequest;
use App\Models\Mantenimiento\ZonaRegistral;
use App\Services\Mantenimiento\ZonaRegistralService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistryZoneController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected ZonaRegistralService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar ZonaRegistral');
        return $this->service->get($request);
    }

    public function store(StoreZonaRegistralRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear ZonaRegistral');
        $data = $this->service->store(
            ZonaRegistralDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateZonaRegistralRequest $request, ZonaRegistral $registryzone)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ZonaRegistral');
        $data = $this->service->update(
            $registryzone,
            ZonaRegistralDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(ZonaRegistral $registryzone)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ZonaRegistral');
        $data = $this->service->findById($registryzone);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(ZonaRegistral $registryzone)
    {
        $this->verifyPermission($this->permissions, 'Desactivar ZonaRegistral');
        $data =  $this->service->disabled($registryzone);
        if ($data) {
            return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(ZonaRegistral $registryzone)
    {
        $this->verifyPermission($this->permissions, 'Activar ZonaRegistral');
        $data =  $this->service->enabled($registryzone);
        if ($data) {
            return $this->success($data, "Activado Correctamente!");
        }
    }
}
