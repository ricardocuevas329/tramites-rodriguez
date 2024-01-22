<?php

namespace App\Services\Administracion;

use App\Dtos\Area\AreaDto;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\Area;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;

class AreaService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Area::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(AreaDto $dto): Area
    {
        $tableName = (new Area())->getTable();
        return Area::create([
            's_codigo' =>  $this->generateCode($tableName, 's_codigo', 5, 'AR'),
            's_nombre' =>   $dto->s_nombre,
            's_descarea' =>   $dto->s_descarea,
            'i_estado' => 1
        ]);
    }

    public function update(Area $area, AreaDto $dto)
    {
        return $area->update([
            's_nombre' =>   $dto->s_nombre,
            's_descarea' =>   $dto->s_descarea,
        ]);
    }

    public function findById(Area $area): Area
    {
        return $area;
    }


    public function disabled(Area $area): Area
    {
        return tap($area)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Area $area): Area
    {
        return tap($area)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Area $area): Area
    {
        return tap($area)->update([
            'i_estado' => 0,
        ]);
    }
}
