<?php

namespace App\Services\Mantenimiento;

use App\Dtos\TipoCompareciente\TipoComparecienteDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\TipoCompareciente;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class TipoComparecienteService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $tipocompareciente = TipoCompareciente::orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($tipocompareciente);
    }


    public function store(TipoComparecienteDto $dto): TipoCompareciente
    {
        $tableName = (new TipoCompareciente())->getTable();

        return TipoCompareciente::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'TC'),
            's_nombre' => $dto->s_nombre,
            's_codigo_sg' => $dto->s_codigo_sg,
            's_tipo_pdt' => $dto->s_tipo_pdt,
            's_color' => $dto->s_color,
            's_clase' => $dto->s_clase,
            'i_estado' => 1
        ]);
    }

    public function update(TipoCompareciente $tipocompareciente, TipoComparecienteDto $dto)
    {
        return $tipocompareciente->update([
            's_nombre' => $dto->s_nombre,
            's_codigo_sg' => $dto->s_codigo_sg,
            's_tipo_pdt' => $dto->s_tipo_pdt,
            's_color' => $dto->s_color,
            's_clase' => $dto->s_clase,
        ]);
    }

    public function findById(TipoCompareciente $tipocompareciente): TipoCompareciente
    {
        return $tipocompareciente;
    }


    public function disabled(TipoCompareciente $tipocompareciente): TipoCompareciente
    {
        return tap($tipocompareciente)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(TipoCompareciente $tipocompareciente): TipoCompareciente
    {
        return tap($tipocompareciente)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(TipoCompareciente $tipocompareciente): TipoCompareciente
    {
        return tap($tipocompareciente)->delete();
    }
}
