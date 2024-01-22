<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Estado\EstadoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Estado;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EstadoService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Estado::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('i_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function getRegister()
    {
        $data = Estado::where('i_codigo', 32)->orderBy('s_desc', 'desc')->get();
        return CollectionResource::collection($data);
    }

    public function getActivos()
    {
            $estado = Estado::activos()
            ->orderBy('i_codigo', 'desc')
            ->get();

        return CollectionResource::collection($estado);
    }

    public function getReferencia()
    {
            $estadoRef = Estado::activosRef()
            ->orderBy('i_codigo', 'desc')
            ->get();

        return CollectionResource::collection($estadoRef);
    }

    public function getCondicion()
    {
            $estadoCon = Estado::activosCon()
            ->orderBy('i_codigo', 'desc')
            ->get();

        return CollectionResource::collection($estadoCon);
    }


    public function store(EstadoDto $dto): Estado
    {

        return Estado::create([
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_tipo' => $dto->s_tipo,
            's_desc' => $dto->s_desc,
            'i_estado' => 1
        ]);
    }

    public function update(Estado $estado, EstadoDto $dto)
    {
        return $estado->update([
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_tipo' => $dto->s_tipo,
            's_desc' => $dto->s_desc,
        ]);
    }

    public function findById(Estado $estado): Estado
    {
        return $estado;
    }


    public function disabled(Estado $estado): Estado
    {
        return tap($estado)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Estado $estado): Estado
    {
        return tap($estado)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Estado $estado): Estado
    {
        return tap($estado)->delete();
    }
}
