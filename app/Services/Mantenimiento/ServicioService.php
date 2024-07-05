<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Servicio\ServicioDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Servicio;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class ServicioService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $area = Servicio::orderBy('s_codigo', 'desc')
            ->Filtros($filtro)
            ->paginate(5);

        return CollectionResource::collection($area);
    }


    public function getActivesAllFast(Request $request)
    {
        $filtro = $request->search;
        $data = Servicio::orderBy('s_nombre', 'asc')
            ->Filtros($filtro)
            ->active()
            ->fast()
            ->limit(5)
            ->get();

        return CollectionResource::collection($data);
    }


    public function store(ServicioDto $dto): Servicio
    {
        $tableName = (new Servicio())->getTable();

        return Servicio::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'S-'),
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_generico' => $dto->s_generico,
            'i_formato' =>  (int) $dto->i_formato,
            'i_rapidos' => (int) $dto->i_rapidos,
            'i_estado' => 1
        ]);
    }

    public function update(Servicio $servicio, ServicioDto $dto)
    {
        return $servicio->update([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_generico' => $dto->s_generico,
            'i_formato' =>  (int) $dto->i_formato,
            'i_rapidos' => (int) $dto->i_rapidos
        ]);
    }

    public function findById(Servicio $servicio): Servicio
    {
        return $servicio;
    }


    public function disabled(Servicio $servicio): Servicio
    {
        return tap($servicio)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Servicio $servicio): Servicio
    {
        return tap($servicio)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Servicio $servicio): Servicio
    {
        return tap($servicio)->delete();
    }
}
