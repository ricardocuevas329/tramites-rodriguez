<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Departamento;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    use ApiResponser;

    public function list(Request $request)
     {
            $filtro = $request->search;
            $data = Departamento::where(function ($query) use ($filtro) {
              return  $query->Filtros($filtro);
            })
             ->orderBy('s_departamento', 'asc')
             ->paginate(5);
         return CollectionResource::collection($data);
     }

    public function all()
    {
        $data = Departamento::orderBy('s_departamento', 'asc')->get();
        return CollectionResource::collection($data);
    }


    public function store(Request $request)
     {

         $request->validate([
             's_departamento' => 'required|min:1|max:100',
         ]);

         $departamento = new Departamento();
         $departamento->s_departamento =  $request->s_departamento;
         $departamento->save();

         return $this->success($departamento, 'Departamento Guardado correctamente');
     }

     public function update(Request $request, $id)
     {
        $request->validate([
            's_departamento' => 'required|min:1|max:100',
            's_codigo' => 'unique:departamento1,s_codigo'.$id.',s_codigo'.'|required|min:2|max:2',
        ]);

        $departamento = Departamento::find($id);
        $departamento->s_departamento =  $request->s_departamento;
        $departamento->save();

        return $this->success($departamento, 'Departamento Actualizado correctamente');
     }

     public function findById($id)
     {

         $departamento =  Departamento::find($id);
         if ($departamento) {
             return $this->success($departamento);
         } else {
             return $this->error("no se encontraron datos", 422);
         }
     }

}
