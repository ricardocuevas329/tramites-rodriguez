<?php

namespace App\Services\Mantenimiento;

use App\Dtos\Cargo\CargoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Cargo;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class CargoService
{

    use GenerateCode;

    public function get(Request $request)
    {

    $filtro = $request->search;
    $data = Cargo::where(function ($query) use ($filtro) {
      $query->filtros($filtro);
    })
      ->orderBy('s_codigo', 'desc')
      ->paginate(5);

    return CollectionResource::collection($data);
  }


    public function store(CargoDto $dto): Cargo
    {
        $tableName = (new Cargo())->getTable();

        return Cargo::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'C'),
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            'i_estado' => 1
        ]);
    }

    public function update(Cargo $cargo, CargoDto $dto)
    {
        return $cargo->update([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
        ]);
    }

    public function findById(Cargo $cargo): Cargo
    {
        return $cargo;
    }


    public function disabled(Cargo $cargo): Cargo
    {
        return tap($cargo)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Cargo $cargo): Cargo
    {
        return tap($cargo)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Cargo $cargo): Cargo
    {
        return tap($cargo)->delete();
    }
}
