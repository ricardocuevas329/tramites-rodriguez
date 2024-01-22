<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Condicion;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConditionController extends Controller
{
    use ApiResponser, MiddlewarePermission;
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
        $this->verifyPermission($this->permissions, 'Listar Condicion');
        $filtro = $request->search;
        $condicion = Condicion::where(function ($query) use ($filtro) {
            $query->nombre($filtro);
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        return CollectionResource::collection($condicion);
    }

    public function store(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Condicion');
        $request->validate([
            'nombre' => 'unique:condicion,nombre|required|min:2|max:60',
            'id_cnl' => 'required|min:2|max:4',
        ]);

        $condicion = new Condicion();
        $condicion->nombre =  $request->nombre;
        $condicion->id_cnl =  $request->id_cnl;
        $condicion->estado = 1;
        $condicion->save();
        return $this->success($condicion, 'Guardado correctamente');
    }

    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Condicion');
        $request->validate([
            'nombre' => 'unique:condicion,nombre,'.$id.'|required|min:2|max:60',
            'id_cnl' => 'required|min:2',
        ]);

        $condicion = Condicion::find($id);
        $condicion->nombre =  $request->nombre;
        $condicion->id_cnl =  $request->id_cnl;
        $condicion->save();
        return $this->success($condicion, 'Actualizado correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Condicion');
        $condicion =  Condicion::find($id);
        if ($condicion) {
            return $this->success($condicion);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }

}
