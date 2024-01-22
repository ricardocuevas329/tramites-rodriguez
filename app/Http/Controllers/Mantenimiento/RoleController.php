<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Role\RoleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Role\StoreRoleRequest;
use App\Http\Requests\Mantenimiento\Role\UpdateRoleRequest;
use App\Models\Mantenimiento\Role;
use App\Services\Mantenimiento\RoleService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponser;

    public function __construct(
        protected RoleService $service
    ) {
    }

    public function list(Request $request)
    {
        return $this->service->get($request);
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $this->service->store(
            RoleDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $this->service->update(
            $role,
            RoleDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Role $role)
    {

        $role = $this->service->findById($role);
        if ($role) {
            return $this->success($role);
        }
        return $this->error("No se encontraron datos", 422);
    }


}
