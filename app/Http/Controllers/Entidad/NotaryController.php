<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Notario\NotarioDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Notario\StoreNotarioRequest;
use App\Http\Requests\Entidad\Notario\UpdateNotarioRequest;
use App\Models\Entidad\Notario;
use App\Services\Entidad\NotarioService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaryController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected NotarioService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Notario');
        return $this->service->get($request);
    }

    public function store(StoreNotarioRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Notario');
        $data = $this->service->store(
            NotarioDto::fromApiRequest($request)
        );

        return $this->success($data, 'Notario Guardado correctamente!');
    }

    public function update(UpdateNotarioRequest $request, Notario $notary)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Notario');
        $data = $this->service->update(
            $notary,
            NotarioDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Notario $notary)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Notario');
        $data = $this->service->findById($notary);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Notario $notary)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Notario');
        $data =  $this->service->disabled($notary);
        if ($data) {
            return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(Notario $notary)
    {
        $this->verifyPermission($this->permissions, 'Activar Notario');
        $data =  $this->service->enabled($notary);
        if ($data) {
            return $this->success($data, "Activado Correctamente!");
        }
    }
}
