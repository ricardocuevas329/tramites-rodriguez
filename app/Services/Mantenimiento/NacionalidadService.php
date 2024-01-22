<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Nacionalidad\NacionalidadDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Nacionalidad;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class NacionalidadService
{

    use GenerateCode;

    public function get(Request $request)
    {
        $filtro = $request->search;
        $data = Nacionalidad::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function getAll(Request $request)
    {
        $data = Nacionalidad::orderBy('s_codigo', 'desc')
            ->Actives()
            ->get();

        return CollectionResource::collection($data);
    }
    public function store(NacionalidadDto $dto): Nacionalidad
    {
        $tableName = (new Nacionalidad())->getTable();
        return Nacionalidad::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'N'),
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_gentilicio' => $dto->s_gentilicio,
            's_pais' => $dto->s_pais,
            'i_estado' => 1
        ]);
    }

    public function update(Nacionalidad $nacionalidad, NacionalidadDto $dto)
    {
        return $nacionalidad->update([
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_gentilicio' => $dto->s_gentilicio,
            's_pais' => $dto->s_pais,
        ]);
    }

    public function findById(Nacionalidad $nacionalidad): Nacionalidad
    {
        return $nacionalidad;
    }


    public function disabled(Nacionalidad $nacionalidad): Nacionalidad
    {
        return tap($nacionalidad)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Nacionalidad $nacionalidad): Nacionalidad
    {
        return tap($nacionalidad)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Nacionalidad $nacionalidad): Nacionalidad
    {
        return tap($nacionalidad)->delete();
    }
}
