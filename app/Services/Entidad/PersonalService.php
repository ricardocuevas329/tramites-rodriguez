<?php

namespace App\Services\Entidad;

use App\Dtos\Personal\PersonalDto;
use App\Http\Resources\CollectionResource;
use App\Models\User;
use App\Services\Mantenimiento\PermissionService;
use App\Services\Mantenimiento\RoleService;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalService
{

    use GenerateCode;

    public function __construct(
        protected RoleService       $RoleService,
        protected PermissionService $PermissionService,
    )
    {

    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = User::where(function ($query) use ($filtro) {
            $query->Filtros($filtro);
        })
            ->NotSuperAdmin()
            ->orderBy('s_codigo', 'desc')
            ->with(['tipo_documento', 'ubigeo', 'nacionalidad', 'roles', 'permissions'])
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function searchPersonal(Request $request)
    {

            $filtro = $request->search;
            $data = User::where(function ($query) use ($filtro) {
                $query->Filtros($filtro);
            })
            ->NotSuperAdmin()
            ->actives()
            ->orderBy('s_codigo', 'desc')
            ->limit(5)
            ->get();

        return CollectionResource::collection($data);
    }

    public function store(PersonalDto $dto): User
    {

        $personal = new User($dto->toArray(), [
            's_estadoCivil' => $dto->estado_civil,
        ]);
        $personal->save();
        if ($personal) {
            $this->RoleService->updateRoles($personal, $dto->roles);
            $this->PermissionService->updatePermissions($personal, $dto->permissions);
        }

        return $personal;
    }

    public function update(User $personal, PersonalDto $dto): User
    {

        $merged = array_merge($dto->toArray(), [
            's_estadoCivil' => $dto->estado_civil,
            's_pass' => $dto->s_pass ?? $personal->s_pass
        ]);
        $personal->update($merged);

        $this->RoleService->updateRoles($personal, $dto->roles);
        $this->PermissionService->updatePermissions($personal, $dto->permissions);

        return $personal;

    }

    public function findById(User $personal): User
    {
        return User::with(['ubigeo', 'tipo_documento', 'roles', 'permissions'])->findOrFail($personal->s_codigo);
    }


    public function authenticated()
    {
        $user = User::with(['ubigeo', 'tipo_documento', 'roles', 'permissions'])->findOrFail(Auth::user()->s_codigo);
        $rolesName = $user->roles->pluck('name');
        $permissionsName = $user->permissions->pluck('name');

        $userArray = $user->toArray();
        return array_merge($userArray, [
            'roles_name' => $rolesName,
            'permissions_name' => $permissionsName,
        ]);


    }


    public function disabled(User $personal): User
    {
        return tap($personal)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(User $personal): User
    {
        return tap($personal)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(User $personal): User
    {
        return tap($personal)->delete();
    }
}
