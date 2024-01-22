<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\TipoCompareciente\TipoComparecienteDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\TipoCompareciente\StoreTipoComparecienteRequest;
use App\Http\Requests\Mantenimiento\TipoCompareciente\UpdateTipoComparecienteRequest;
use App\Models\Mantenimiento\TipoCompareciente;
use App\Services\Mantenimiento\TipoComparecienteService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeComparisonController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected TipoComparecienteService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar TipoCompareciente');
        return $this->service->get($request);
    }

    public function store(StoreTipoComparecienteRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear TipoCompareciente');
        $data = $this->service->store(
            TipoComparecienteDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateTipoComparecienteRequest $request, TipoCompareciente $tipocompareciente)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoCompareciente');
        $data = $this->service->update(
            $tipocompareciente,
            TipoComparecienteDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(TipoCompareciente $tipocompareciente)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoCompareciente');
        $tipocompareciente = $this->service->findById($tipocompareciente);
        if ($tipocompareciente) {
            return $this->success($tipocompareciente);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(TipoCompareciente $tipocompareciente)
    {
        $this->verifyPermission($this->permissions, 'Desactivar TipoCompareciente');
        $tipocompareciente =  $this->service->disabled($tipocompareciente);
        if ($tipocompareciente) {
            return $this->success($tipocompareciente, "Desactivado Correctamente!");
        }
    }

    public function enabled(TipoCompareciente $tipocompareciente)
    {
        $this->verifyPermission($this->permissions, 'Activar TipoCompareciente');
        $tipocompareciente =  $this->service->enabled($tipocompareciente);
        if ($tipocompareciente) {
            return $this->success($tipocompareciente, "Activado Correctamente!");
        }
    }
}
