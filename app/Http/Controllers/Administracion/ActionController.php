<?php

namespace App\Http\Controllers\Administracion;

use App\Dtos\Accion\AccionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\Accion\StoreAccionRequest;
use App\Http\Requests\Administracion\Accion\UpdateAccionRequest;
use App\Models\Administracion\Accion;
use App\Services\Administracion\AccionService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected AccionService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function listar(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Accion');
        return $this->service->get($request);
    }

    public function store(StoreAccionRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Accion');
        $data = $this->service->store(
            AccionDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateAccionRequest $request, Accion $action)
    {

        $this->verifyPermission($this->permissions, 'Actualizar Accion');
        $data = $this->service->update(
            $action,
            AccionDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Accion $action)
    {

        $this->verifyPermission($this->permissions, 'Actualizar Accion');
        $data = $this->service->findById($action);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Accion $action)
    {

        $this->verifyPermission($this->permissions, 'Desactivar Accion');
        $data =  $this->service->disabled($action);
        if ($data) {
         return $this->success($data, "Desactivado Correctamente!");
        }

    }

    public function enabled(Accion $action)
    {
        $this->verifyPermission($this->permissions, 'Activar Accion');
        $data =  $this->service->enabled($action);
        if ($data) {
         return $this->success($data, "Activado Correctamente!");
        }

    }
}
