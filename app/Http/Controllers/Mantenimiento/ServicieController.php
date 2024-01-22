<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Servicio\ServicioDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Servicio\StoreServicioRequest;
use App\Http\Requests\Mantenimiento\Servicio\UpdateServicioRequest;
use App\Models\Mantenimiento\Servicio;
use App\Services\Mantenimiento\ServicioService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicieController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected ServicioService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Activar Servicio');
        return $this->service->get($request);
    }

    public function store(StoreServicioRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Servicio');
        $data = $this->service->store(
            ServicioDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateServicioRequest $request, Servicio $service)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Servicio');
        $data = $this->service->update(
            $service,
            ServicioDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Servicio $service)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Servicio');
        $data = $this->service->findById($service);
        if ($data) {
            return $this->success($data);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Servicio $service)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Servicio');
        $data =  $this->service->disabled($service);
        if ($data) {
        return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(Servicio $service)
    {
        $this->verifyPermission($this->permissions, 'Activar Servicio');
        $data =  $this->service->enabled($service);
        if ($data) {
        return $this->success($data, "Activado Correctamente!");
        }

    }
}
