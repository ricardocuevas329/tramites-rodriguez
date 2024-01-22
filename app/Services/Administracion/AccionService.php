<?php

namespace App\Services\Administracion;

use App\Dtos\Accion\AccionDto;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\Accion;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccionService
{

    use GenerateCode;

    public function get(Request $request)
    {

            $filtro = $request->search;
            $data = Accion::where(function ($query) use ($filtro) {
                $query->filtros($filtro);
            })->orderBy('i_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(AccionDto $dto): Accion
    {
        return Accion::create([
            //'i_codigo' => $this->generateCode('acciones', 'i_codigo', 10, 'A-'),
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_codper' => $dto->s_codper,
            'd_fecha_reg' => date("Y-m-d H:i:s"),
            's_personal_reg' => Auth::user()->s_codigo,
            'i_estado' => 1
        ]);
    }

    public function update(Accion $accion, AccionDto $dto)
    {
        return $accion->update([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_codper' => $dto->s_codper,
        ]);
    }

    public function findById(Accion $accion): Accion
    {
        return $accion;
    }


    public function disabled(Accion $accion): Accion
    {
        return tap($accion)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Accion $accion): Accion
    {
        return tap($accion)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Accion $accion): Accion
    {
        return tap($accion)->update([
            'i_estado' => 0,
        ]);
    }
}
