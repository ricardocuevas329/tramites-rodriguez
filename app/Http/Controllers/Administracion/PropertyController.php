<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\Bien;
use App\Traits\{ApiResponser,GenerateCode, MiddlewarePermission};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    use ApiResponser, GenerateCode, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }



    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Bienes');
        $filtro = $request->search;
        $data = Bien::where(function ($query) use ($filtro) {
            $query->snombre($filtro)
                ->sdescripcion($filtro);
        })
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);
        return CollectionResource::collection($data);
    }

    public function store(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Bienes');
        $request->validate([
            's_nombre' => 'unique:bienes,s_nombre|required|min:2|max:150',
            's_descripcion' => 'required|min:2|max:250',
        ]);

        $property = new Bien();
        $property->s_codigo = $this->generateCode('bienes','s_codigo', 5, 'B');
        $property->s_nombre =  $request->s_nombre;
        $property->s_decripcion =  $request->s_descripcion;
        $property->i_estado = 1;
        $property->save();
        return $this->success($property, 'Guardado correctamente');
    }


    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Bienes');
        $request->validate([
            's_nombre' => 'unique:bienes,s_nombre,'.$id.',s_codigo'.'|required|min:2|max:150',
            's_descripcion' => 'required|min:2|max:250',
        ]);

        $property = Bien::find($id);
        $property->s_nombre =  $request->s_nombre;
        $property->s_decripcion =  $request->s_descripcion;
        $property->save();
        return $this->success($property, 'Actualizado correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Bienes');
        $data =  Bien::find($id);
        if ($data) {
            return $this->success($data);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }

    public function disabled($id)
    {
        $this->verifyPermission($this->permissions, 'Desactivar Bienes');
        $property =  Bien::find($id);
        $property->i_estado = 0;
        $property->save();
        return $this->success($property, "Desactivado Correctamente!");
    }

    public function enabled($id)
    {
        $this->verifyPermission($this->permissions, 'Activar Bienes');
        $property = Bien::find($id);
        $property->i_estado = 1;
        $property->save();
        return $this->success($property, "Activado Correctamente!");
    }
}
