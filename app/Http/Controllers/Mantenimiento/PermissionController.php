<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\Permission\PermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\Permission\StorePermissionRequest;
use App\Http\Requests\Mantenimiento\Permission\UpdatePermissionRequest;
use App\Models\Mantenimiento\Permission;
use App\Services\Mantenimiento\PermissionService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use ApiResponser;

    public function __construct(
        protected PermissionService $service
    ) {
    }

    public function list(Request $request)
    {
        return $this->service->get($request);
    }

    public function store(StorePermissionRequest $request)
    {
        $data = $this->service->store(
            PermissionDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $data = $this->service->update(
            $permission,
            PermissionDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Permission $permission)
    {

        $permission = $this->service->findById($permission);
        if ($permission) {
            return $this->success($permission);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Permission $permission)
    {

        $permission =  $this->service->disabled($permission);
        if ($permission) {
            return $this->success($permission, "Desactivado Correctamente!");
        }
    }

    public function enabled(Permission $permission)
    {
        $permission =  $this->service->enabled($permission);
        if ($permission) {
            return $this->success($permission, "Activado Correctamente!");
        }
    }
}
