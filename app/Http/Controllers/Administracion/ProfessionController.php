<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\Profesion;
use App\Traits\ApiResponser;
use App\Traits\GenerateCode;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionController extends Controller
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
        $this->verifyPermission($this->permissions, 'Listar Profesion');
        $filtro = $request->search;
        $profesion = Profesion::where(function ($query) use ($filtro) {
            $query->snombre($filtro);
        })
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);
        return CollectionResource::collection($profesion);
     }

    public function store(Request $request)
     {
         $this->verifyPermission($this->permissions, 'Crear Profesion');
         $request->validate([
            's_codigo_sbs' => 'required|min:2|max:5',
             's_nombre' => 'required|min:3|max:50',
             's_nombref' => 'required|min:3|max:50',
             'i_tipo' => 'required|min:1|max:2',
             's_descripcion' => 'min:0|max:50',

         ]);


         $profesion = new Profesion();
         $profesion->s_codigo = $this->generateCode('profesion','s_codigo', 5, 'P');
         $profesion->s_codigo_sbs =  $request->s_codigo_sbs;
         $profesion->s_nombre =  $request->s_nombre;
         $profesion->s_nombref =  $request->s_nombref;
         $profesion->i_tipo =  $request->i_tipo;
         $profesion->s_descripcion =  $request->s_descripcion;
         $profesion->i_estado = 1;
         $profesion->save();

         return $this->success($profesion, 'Guardado correctamente');
     }

     public function update(Request $request, $id)
     {

        $this->verifyPermission($this->permissions, 'Actualizar Profesion');
         $request->validate([
            's_codigo_sbs' => 'required|min:3|max:50',
            's_nombre' => 'required|min:3|max:50',
             's_nombref' => 'required|min:3|max:50',
             'i_tipo' => 'required|min:1|max:2',
             's_descripcion' => 'min:0|max:50',
         ]);

         $profesion = Profesion::find($id);
         $profesion->s_codigo_sbs =  $request->s_codigo_sbs;
         $profesion->s_nombre =  $request->s_nombre;
         $profesion->s_nombref =  $request->s_nombref;
         $profesion->i_tipo =  $request->i_tipo;
         $profesion->s_descripcion =  $request->s_descripcion;
         $profesion->i_estado = 1;
         $profesion->save();
         return $this->success($profesion, 'Actualizado correctamente');
     }

     public function findById($id)
     {
         $this->verifyPermission($this->permissions, 'Actualizar Profesion');
         $profesion =  Profesion::find($id);
         if ($profesion) {
             return $this->success($profesion);
         } else {
             return $this->error("No se encontraron datos", 422);
         }
     }

     public function disabled($id)
     {
         $this->verifyPermission($this->permissions, 'Desactivar Profesion');
         $profesion =  Profesion::find($id);
         $profesion->i_estado = 0;
         $profesion->save();
         return $this->success($profesion, "Desactivado Correctamente!");
     }

     public function enabled($id)
     {
         $this->verifyPermission($this->permissions, 'Activar Profesion');
         $profesion = Profesion::find($id);
         $profesion->i_estado = 1;
         $profesion->save();
         return $this->success($profesion, "Activado Correctamente!");
     }
}
