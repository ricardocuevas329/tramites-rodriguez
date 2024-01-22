<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Distrito;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    use ApiResponser;

    public function list(Request $request)
    {
    }



    public function store(Request $request)
    {

        if ($request->distritos) {
            foreach ($request->distritos as $item) {
                $distrito = new Distrito();
                $distrito->s_codigo =  $item['provincia'].$item['s_codigo'];
                $distrito->s_distrito =  $item['s_distrito'];
                $distrito->save();
            }

            return $this->success($distrito, 'Distrito Guardado correctamente');
        }
    }

    public function update(Request $request, $id)
    {


    }

    public function findById($id)
    {
        $distrito =  Distrito::find($id);
        if ($distrito) {
            return $this->success($distrito);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }
}
