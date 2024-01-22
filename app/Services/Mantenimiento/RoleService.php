<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Role\RoleDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleService  extends Controller
{


    public function get(Request $request)
    {

        $filtro = $request->search;
        $requisito = Role::orderBy('name', 'asc')
        ->where('name','!=','superadmin')
        ->paginate(50);
        return CollectionResource::collection($requisito);
    }


    public function store(RoleDto $dto): Role
    {
        return Role::create(['name' => $dto->name]);
    }

    public function update(Role $role, RoleDto $dto)
    {
        return $role->update(['name' => $dto->name]);
    }

    public function updateRoles(User $user, Array|Role $roles)
    {

        if($user->roles()->where('name','superadmin')->first()){
            $rolSuperAdmin = ["superadmin"];
        }else{
            $rolSuperAdmin = [];
        }

        if(count($roles)){
            $roleNames = array_column($roles, 'name');
            $payload = Role::whereIn('name', $roleNames)->get();
            $user->syncRoles( $rolSuperAdmin , ...$payload);
        }else{
            $user->syncRoles([]);
        }

    }


    public function findById(Role $role): Role
    {
        return $role;
    }


}
