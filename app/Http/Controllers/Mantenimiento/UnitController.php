<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Unidad\UnidadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Unidad\StoreUnidadRequest;
use App\Http\Requests\Mantenimiento\Unidad\UpdateUnidadRequest;
use App\Models\Mantenimiento\Unidad;
use App\Services\Mantenimiento\UnidadService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected UnidadService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Unidad');
        return $this->service->get($request);
    }

    public function store(StoreUnidadRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Unidad');
        $data = $this->service->store(
            UnidadDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateUnidadRequest $request, Unidad $unidad)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Unidad');
        $data = $this->service->update(
            $unidad,
            UnidadDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Unidad $unidad)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Unidad');
        $unidad = $this->service->findById($unidad);
        if ($unidad) {
            return $this->success($unidad);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Unidad $unidad)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Unidad');
        $unidad =  $this->service->disabled($unidad);
        if ($unidad) {
        return $this->success($unidad, "Desactivado Correctamente!");
        }
    }

    public function enabled(Unidad $unidad)
    {
        $this->verifyPermission($this->permissions, 'Activar Unidad');
        $unidad =  $this->service->enabled($unidad);
        if ($unidad) {
        return $this->success($unidad, "Activado Correctamente!");
        }

    }
}
