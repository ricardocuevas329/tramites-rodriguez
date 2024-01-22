<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Nacionalidad\NacionalidadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Nacionalidad\StoreNacionalidadRequest;
use App\Http\Requests\Mantenimiento\Nacionalidad\UpdateNacionalidadRequest;
use App\Models\Mantenimiento\Nacionalidad;
use App\Services\Mantenimiento\NacionalidadService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NationalityController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected NacionalidadService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }



    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Nacionalidad');
        return $this->service->get($request);
    }

    public function store(StoreNacionalidadRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Nacionalidad');
        $data = $this->service->store(
            NacionalidadDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateNacionalidadRequest $request, Nacionalidad $Nacionalidad)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Nacionalidad');
        $data = $this->service->update(
            $Nacionalidad,
            NacionalidadDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Nacionalidad $nacionalidad)
    {

        $this->verifyPermission($this->permissions, 'Actualizar Nacionalidad');
        $nacionalidad = $this->service->findById($nacionalidad);
        if ($nacionalidad) {
            return $this->success($nacionalidad);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Nacionalidad $nacionalidad)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Nacionalidad');
        $nacionalidad =  $this->service->disabled($nacionalidad);
        if ($nacionalidad) {
            return $this->success($nacionalidad, "Desactivado Correctamente!");
        }
    }

    public function enabled(Nacionalidad $nacionalidad)
    {
        $this->verifyPermission($this->permissions, 'Activar Nacionalidad');
        $nacionalidad =  $this->service->enabled($nacionalidad);
        if ($nacionalidad) {
            return $this->success($nacionalidad, "Activado Correctamente!");
        }
    }

    public function listarAll(Request $request)
    {
        return $this->service->getAll($request);
    }
}
