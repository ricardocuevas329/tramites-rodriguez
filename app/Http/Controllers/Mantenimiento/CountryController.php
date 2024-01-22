<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Pais\PaisDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Pais\StorePaisRequest;
use App\Http\Requests\Mantenimiento\Pais\UpdatePaisRequest;
use App\Models\Mantenimiento\Pais;
use App\Services\Mantenimiento\PaisService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected PaisService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Activar Pais');
        return $this->service->get($request);
    }

    public function store(StorePaisRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Pais');
        $data = $this->service->store(
            PaisDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdatePaisRequest $request, Pais $pais)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Pais');
        $data = $this->service->update(
            $pais,
            PaisDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Pais $pais)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Pais');
        $pais = $this->service->findById($pais);
        if ($pais) {
            return $this->success($pais);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Pais $pais)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Pais');
        $pais =  $this->service->disabled($pais);
        if ($pais) {
            return $this->success($pais, "Desactivado Correctamente!");
        }
    }

    public function enabled(Pais $pais)
    {
        $this->verifyPermission($this->permissions, 'Activar Pais');
        $pais =  $this->service->enabled($pais);
        if ($pais) {
            return $this->success($pais, "Activado Correctamente!");
        }
    }
}
