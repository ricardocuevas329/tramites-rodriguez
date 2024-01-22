<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Pais\PaisDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Pais;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class PaisService
{

    use GenerateCode;

    public function get(Request $request)
    {
        $filtro = $request->search;
        $data = Pais::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(PaisDto $dto): Pais
    {
        $tableName = (new Pais())->getTable();
        return Pais::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'N'),
            's_gentilicio_f' => $dto->s_gentilicio_f,
            's_gentilicio_m' => $dto->s_gentilicio_m,
            's_pais' => $dto->s_pais,
            'i_estado' => 1
        ]);
    }

    public function update(Pais $pais, PaisDto $dto)
    {
        return $pais->update([
            's_gentilicio_f' => $dto->s_gentilicio_f,
            's_gentilicio_m' => $dto->s_gentilicio_m,
            's_pais' => $dto->s_pais,
        ]);
    }

    public function findById(Pais $pais): Pais
    {
        return $pais;
    }


    public function disabled(Pais $pais): Pais
    {
        return tap($pais)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Pais $pais): Pais
    {
        return tap($pais)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Pais $pais): Pais
    {
        return tap($pais)->delete();
    }
}
