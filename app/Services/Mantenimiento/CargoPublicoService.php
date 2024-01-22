<?php

namespace App\Services\Mantenimiento;

use App\Dtos\CargoPublico\CargoPublicoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\CargoPublico;
use Illuminate\Http\Request;


class CargoPublicoService
{


  public function get(Request $request)
  {

    $filtro = $request->search;
    $cargopublico = CargoPublico::where(function ($query) use ($filtro) {
      $query->snombre($filtro);
    })
      ->orderBy('codigo', 'desc')
      ->paginate(5);
    return CollectionResource::collection($cargopublico);
  }


  public function store(CargoPublicoDto $dto): CargoPublico
  {

    return CargoPublico::create([
      'codigo' => $dto->codigo,
      's_descripcion' => $dto->descripcion,
      'i_estado' => 1
    ]);
  }

  public function update(CargoPublico $cargopublico, CargoPublicoDto $dto)
  {
    return $cargopublico->update([
      'codigo' => $dto->codigo,
      'descripcion' => $dto->descripcion,
      'i_estado' => 1
    ]);
  }

  public function findById(CargoPublico $cargopublico): CargoPublico
  {
    return $cargopublico;
  }


  public function disabled(CargoPublico $cargopublico): CargoPublico
  {
    return tap($cargopublico)->update([
      'i_estado' => 0,
    ]);
  }

  public function enabled(CargoPublico $cargopublico): CargoPublico
  {
    return tap($cargopublico)->update([
      'i_estado' => 1,
    ]);
  }

  public function destroy(CargoPublico $cargopublico): CargoPublico
  {
    return tap($cargopublico)->delete();
  }
}
