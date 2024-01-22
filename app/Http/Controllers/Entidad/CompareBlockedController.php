<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\ComparecienteBloqueado\ComparecienteBloqueadoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\ComparecienteBloqueado\StoreComparecienteBloqueadoRequest;
use App\Http\Requests\Entidad\ComparecienteBloqueado\UpdateComparecienteBloqueadoRequest;
use App\Models\Entidad\ComparecienteBloqueado;
use App\Services\Entidad\ComparecienteBloqueadoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareBlockedController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected ComparecienteBloqueadoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar ComparecienteBloqueado');
        return $this->service->get($request);


    }

    public function store(StoreComparecienteBloqueadoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear ComparecienteBloqueado');
        $data = $this->service->store(
            ComparecienteBloqueadoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateComparecienteBloqueadoRequest $request, ComparecienteBloqueado $compareblocked)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ComparecienteBloqueado');
        $data = $this->service->update(
            $compareblocked,
            ComparecienteBloqueadoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(ComparecienteBloqueado $compareblocked)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ComparecienteBloqueado');
        $data = $this->service->findById($compareblocked);
        if ($data) {
            return $this->success($data);
        }
            return $this->error("No se encontraron datos", 422);

    }

    public function disabled(ComparecienteBloqueado $compareblocked)
    {
        $this->verifyPermission($this->permissions, 'Desactivar ComparecienteBloqueado');
        $data =  $this->service->disabled($compareblocked);
        if ($data) {
        return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(ComparecienteBloqueado $compareblocked)
    {
        $this->verifyPermission($this->permissions, 'Activar ComparecienteBloqueado');
        $data =  $this->service->enabled($compareblocked);
        if ($data) {
        return $this->success($data, "Activado Correctamente!");
        }
    }

    public function clearFile(ComparecienteBloqueado $compareblocked)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ComparecienteBloqueado');
        $data = $this->service->destroyFile(
            $compareblocked
        );
        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }
}
