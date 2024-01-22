<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Unidad\UnidadDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Unidad;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class UnidadService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $area = Unidad::orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($area);
    }


    public function store(UnidadDto $dto): Unidad
    {
        $tableName = (new Unidad())->getTable();
       
        return Unidad::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'U-'),
            's_nombre' => $dto->s_nombre,
            's_abrev' => $dto->s_abrev,
            's_observacion' => $dto->s_observacion,
            'i_estado' => 1
        ]);
    }

    public function update(Unidad $unidad, UnidadDto $dto)
    {
        return $unidad->update([
            's_nombre' => $dto->s_nombre,
            's_abrev' => $dto->s_abrev,
            's_observacion' => $dto->s_observacion,
        ]);
    }

    public function findById(Unidad $unidad): Unidad
    {
        return $unidad;
    }


    public function disabled(Unidad $unidad): Unidad
    {
        return tap($unidad)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Unidad $unidad): Unidad
    {
        return tap($unidad)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Unidad $unidad): Unidad
    {
        return tap($unidad)->delete();
    }
}
