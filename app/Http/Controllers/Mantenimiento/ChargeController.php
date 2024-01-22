<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Cargo\CargoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Cargo\StoreCargoRequest;
use App\Http\Requests\Mantenimiento\Cargo\UpdateCargoRequest;
use App\Models\Mantenimiento\Cargo;
use App\Services\Mantenimiento\CargoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected CargoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Cargo');
        return $this->service->get($request);
    }

    public function store(StoreCargoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Cargo');
        $data = $this->service->store(
            CargoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Cargo');
        $data = $this->service->update(
            $cargo,
            CargoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Cargo $cargo)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Cargo');
        $cargo = $this->service->findById($cargo);
        if ($cargo) {
            return $this->success($cargo);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Cargo $cargo)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Cargo');
        $cargo =  $this->service->disabled($cargo);
        if ($cargo) {
        return $this->success($cargo, "Desactivado Correctamente!");
        }
    }

    public function enabled(Cargo $cargo)
    {
        $this->verifyPermission($this->permissions, 'Activar Cargo');
        $cargo =  $this->service->enabled($cargo);
        if ($cargo) {
        return $this->success($cargo, "Activado Correctamente!");
        }

    }
}
