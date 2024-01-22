<?php

namespace App\Services\Entidad;

use App\Dtos\Abogado\AbogadoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Abogado;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;

class AbogadoService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
            $data = Abogado::where(function ($query) use ($filtro) {
                $query->Filtros($filtro);
            })
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(AbogadoDto $dto): Abogado
    {
        $tableName = (new Abogado())->getTable();
        return Abogado::create([
            's_codigo' =>  $this->generateCode($tableName, 's_codigo', 5, 'AB'),
            's_materno' =>   $dto->s_materno,
            's_paterno' =>   $dto->s_paterno,
            's_nombres' =>   $dto->s_nombres,
            's_sexo' =>    $dto->s_sexo,
            's_telefono' =>   $dto->s_telefono,
            's_cal' =>  $dto->s_cal,
            's_colegio' =>   $dto->s_colegio,
            's_personal' =>   $dto->s_personal,
            'i_estado' => 1
        ]);
    }

    public function update(Abogado $accion, AbogadoDto $dto)
    {
        return $accion->update([
            's_materno' =>   $dto->s_materno,
            's_paterno' =>   $dto->s_paterno,
            's_nombres' =>   $dto->s_nombres,
            's_sexo' =>    $dto->s_sexo,
            's_telefono' =>   $dto->s_telefono,
            's_cal' =>  $dto->s_cal,
            's_colegio' =>   $dto->s_colegio,
            's_personal' =>   $dto->s_personal,
        ]);
    }

    public function findById(Abogado $abogado): Abogado
    {
      return $abogado;
    }


    public function disabled(Abogado $abogado): Abogado
    {
        return tap($abogado)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Abogado $abogado): Abogado
    {
        return tap($abogado)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Abogado $abogado): Abogado
    {
        return tap($abogado)->update([
            'i_estado' => 0,
        ]);
    }
}
