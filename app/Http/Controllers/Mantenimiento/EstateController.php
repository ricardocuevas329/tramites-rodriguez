<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Estado\EstadoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Estado\StoreEstadoRequest;
use App\Http\Requests\Mantenimiento\Estado\UpdateEstadoRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Estado;
use App\Services\Mantenimiento\EstadoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected EstadoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar TipoEstado');
        return $this->service->get($request);
    }

    public function activos()
    {
        $this->verifyPermission($this->permissions, 'Listar estados activos');
        return $this->service->getActivos();
    }

    public function referencia()
    {
        return $this->service->getReferencia();
    }

    public function condicion()
    {
        return $this->service->getCondicion();
    }

    public function store(StoreEstadoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear TipoEstado');
        $data = $this->service->store(
            EstadoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateEstadoRequest $request, Estado $estado)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoEstado');
        $data = $this->service->update(
            $estado,
            EstadoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Estado $estado)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoEstado');
        $estado = $this->service->findById($estado);
        if ($estado) {
            return $this->success($estado);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Estado $estado)
    {
        $this->verifyPermission($this->permissions, 'Desactivar TipoEstado');
        $estado =  $this->service->disabled($estado);
        if ($estado) {
            return $this->success($estado, "Desactivado Correctamente!");
        }
    }

    public function enabled(Estado $estado)
    {
        $this->verifyPermission($this->permissions, 'Activar TipoEstado');
        $estado =  $this->service->enabled($estado);
        if ($estado) {
            return $this->success($estado, "Activado Correctamente!");
        }
    }

    public function registroFirma()
    {
        return $this->service->getRegister();
    }


}
