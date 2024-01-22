<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Permission\PermissionDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Permission;
use App\Models\User;
use Illuminate\Http\Request;


class PermissionService  extends Controller
{

    public function get(Request $request)
    {
        $filtro = $request->search; 
        $requisito =  Permission::Filtros($filtro)->orderBy('id', 'desc')->paginate(200);
        return CollectionResource::collection($requisito);
    }

    public function store(PermissionDto $dto): Permission
    {
        return Permission::create(['name' => $dto->name]);
    }

    public function update(Permission $role, PermissionDto $dto)
    {
        return $role->update(['name' => $dto->name]);
    }

    public function updatePermissions(User $user, Array|Permission $permissions)
    {
        if(count($permissions)){
            $payload = collect([]);
           
            foreach ($permissions as $key => $value) {
                $payload->push($value['name']);
            }
            $user->syncPermissions($payload);
        }else{
            $user->syncPermissions([]);
        }

    }


    public function findById(Permission $role): Permission
    {
        return $role;
    }
 
}
