<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Requisito\RequisitoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Requisito\StoreRequisitoRequest;
use App\Http\Requests\Mantenimiento\Requisito\UpdateRequisitoRequest;
use App\Models\Mantenimiento\Requisito;
use App\Services\Mantenimiento\RequisitoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected RequisitoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Activar Requisito');
        return $this->service->get($request);
    }

    public function store(StoreRequisitoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Requisito');
        $data = $this->service->store(
            RequisitoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateRequisitoRequest $request, Requisito $requisito)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Requisito');
        $data = $this->service->update(
            $requisito,
            RequisitoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Requisito $requisito)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Requisito');
        $requisito = $this->service->findById($requisito);
        if ($requisito) {
            return $this->success($requisito);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Requisito $requisito)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Requisito');
        $requisito =  $this->service->disabled($requisito);
        if ($requisito) {
        return $this->success($requisito, "Desactivado Correctamente!");
        }
    }

    public function enabled(Requisito $requisito)
    {
        $this->verifyPermission($this->permissions, 'Activar Requisito');
        $requisito =  $this->service->enabled($requisito);
        if ($requisito) {
        return $this->success($requisito, "Activado Correctamente!");
        }

    }
}
