<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\CargoPublico\CargoPublicoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\CargoPublico\StoreCargoPublicoRequest;
use App\Http\Requests\Mantenimiento\CargoPublico\UpdateCargoPublicoRequest;
use App\Models\Mantenimiento\CargoPublico;
use App\Services\Mantenimiento\CargoPublicoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChargePublicController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected CargoPublicoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar CargoPublico');
        return $this->service->get($request);
    }

    public function store(StoreCargoPublicoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear CargoPublico');
        $data = $this->service->store(
            CargoPublicoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateCargoPublicoRequest $request, CargoPublico $cargopublico)
    {
        $this->verifyPermission($this->permissions, 'Actualizar CargoPublico');
        $data = $this->service->update(
            $cargopublico,
            CargoPublicoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(CargoPublico $cargopublico)
    {
        $this->verifyPermission($this->permissions, 'Actualizar CargoPublico');
        $cargopublico = $this->service->findById($cargopublico);
        if ($cargopublico) {
            return $this->success($cargopublico);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(CargoPublico $cargopublico)
    {
        $this->verifyPermission($this->permissions, 'Desactivar CargoPublico');
        $cargopublico =  $this->service->disabled($cargopublico);
        if ($cargopublico) {
        return $this->success($cargopublico, "Desactivado Correctamente!");
        }
    }

    public function enabled(CargoPublico $cargopublico)
    {
        $this->verifyPermission($this->permissions, 'Activar CargoPublico');
        $cargopublico =  $this->service->enabled($cargopublico);
        if ($cargopublico) {
        return $this->success($cargopublico, "Activado Correctamente!");
        }

    }
}
