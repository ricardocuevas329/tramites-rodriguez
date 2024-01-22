<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Personal\PersonalDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Personal\{StorePersonalRequest, UpdatePersonalRequest};
use App\Models\User;
use App\Services\Entidad\PersonalService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected PersonalService $service,
    ) {
        $this->middleware(function ($request, $next) {
              $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
              return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Personal');
        return $this->service->get($request);
    }


    public function search(Request $request)
    {
        return $this->service->searchPersonal($request);
    }

    public function store(StorePersonalRequest $request)
    {

        $this->verifyPermission($this->permissions, 'Crear Personal');
        $data = $this->service->store(
            PersonalDto::fromApiRequest($request)
        );
        return $this->success($data, 'Personal Guardado correctamente!');
    }

    public function update(UpdatePersonalRequest $request, User $personal)
    {

        $this->verifyPermission($this->permissions, 'Actualizar Personal');
        $data = $this->service->update(
            $personal,
            PersonalDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(User $personal)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Personal');
        $personal = $this->service->findById($personal);
        if ($personal) {
            return $this->success($personal);
        }

        return $this->error("No se encontraron datos", 422);
    }




    public function disabled(User $personal)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Personal');
        $personal =  $this->service->disabled($personal);
        if ($personal) {
            return $this->success($personal, "Desactivado Correctamente!");
        }
    }

    public function enabled(User $personal)
    {
        $this->verifyPermission($this->permissions, 'Activar Personal');
        $personal =  $this->service->enabled($personal);
        if ($personal) {
            return $this->success($personal, "Activado Correctamente!");
        }
    }
}
