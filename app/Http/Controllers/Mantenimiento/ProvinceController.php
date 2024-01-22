<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Provincia;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    use ApiResponser;

    public function list(Request $request)
     {

     }


     public function listDepartament(Request $request, string $codigo)
     {

             $filtro = $request->search;
             $provincia = Provincia::departamento($codigo)
             ->orderBy('s_codigo', 'desc')
             ->get();

         return CollectionResource::collection($provincia);
     }


    public function store(Request $request)
     {


       $this->validate($request, [
        'provincias.*.departamento' => 'string|required|min:2|max:2',
        //'provincias.*.s_codigo' => 'string|required|unique:provincia1,s_codigo.s_codigo,s_codigo',
        'provincias.*.s_provincia' => 'string|required|min:1|max:100',
      ]);


         if ($request->provincias) {
            foreach ($request->provincias as $key => $item) {
                $distrito = new Provincia();
                $distrito->s_codigo =  $item['departamento'].$item['s_codigo'];
                $distrito->s_provincia =  $item['s_provincia'];
                $distrito->save();
            }

            return $this->success($distrito, 'Provincia Guardado correctamente');
        }


     }

     public function update(Request $request, $id)
     {


     }

     public function findById($id)
     {
        $provincia =  Provincia::find($id);
        if ($provincia) {
            return $this->success($provincia);
        } else {
            return $this->error("no se encontraron datos", 422);
        }

     }
}
