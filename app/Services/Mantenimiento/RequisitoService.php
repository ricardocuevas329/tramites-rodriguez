<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Requisito\RequisitoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Requisito;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class RequisitoService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $requisito = Requisito::where(function ($query) use ($filtro) {
        $query->snombre($filtro);
        })
        ->orderBy('s_codigo', 'desc')
        ->paginate(5);
        return CollectionResource::collection($requisito);
    }


    public function store(RequisitoDto $dto): Requisito
    {
        $tableName = (new Requisito())->getTable();

        return Requisito::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'R'),
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            'i_estado' => 1
        ]);
    }

    public function update(Requisito $requisito, RequisitoDto $dto)
    {
        return $requisito->update([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
        ]);
    }

    public function findById(Requisito $requisito): Requisito
    {
        return $requisito;
    }


    public function disabled(Requisito $requisito): Requisito
    {
        return tap($requisito)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Requisito $requisito): Requisito
    {
        return tap($requisito)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Requisito $requisito): Requisito
    {
        return tap($requisito)->delete();
    }
}
