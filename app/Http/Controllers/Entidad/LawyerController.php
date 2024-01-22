<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Abogado\AbogadoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Abogado\StoreAbogadoRequest;
use App\Http\Requests\Entidad\Abogado\UpdateAbogadoRequest;
use App\Models\Entidad\Abogado;
use App\Services\Entidad\AbogadoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected AbogadoService $service,
    ) {
       $this->middleware(function ($request, $next) {
          $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
          return $next($request);
       });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Abogado');
        return $this->service->get($request);
    }

    public function store(StoreAbogadoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Abogado');
        $data = $this->service->store(
            AbogadoDto::fromApiRequest($request)
        );
        return $this->success($data, 'Abogado Guardado correctamente!');
    }

    public function update(UpdateAbogadoRequest $request, Abogado $lawyer)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Abogado');
        $data = $this->service->update(
            $lawyer,
            AbogadoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Abogado $lawyer)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Abogado');
        $data = $this->service->findById($lawyer);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Abogado $lawyer)
    {
        $this->verifyPermission($this->permissions, 'Activar Abogado');
        $data =  $this->service->disabled($lawyer);
        if ($data) {
            return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(Abogado $lawyer)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Abogado');
        $data =  $this->service->enabled($lawyer);
        if ($data) {
            return $this->success($data, "Activado Correctamente!");
        }
    }
}
