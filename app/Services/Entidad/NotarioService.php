<?php

namespace App\Services\Entidad;

use App\Dtos\Notario\NotarioDto;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Notario;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class NotarioService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $notario = Notario::orderBy('s_codigo', 'desc')
            ->Filtros($filtro)
            ->with(['tipo_documento'])
            ->paginate(5);

        return CollectionResource::collection($notario);
    }


    public function store(NotarioDto $dto): Notario
    {

        $tableName = (new Notario())->getTable();
        return Notario::create([
            's_codigo' =>  $this->generateCode($tableName, 's_codigo', 10, 'NO'),
            's_tipodoc' => $dto->s_tipodoc,
            's_numdoc' => $dto->s_numdoc,
            's_cargo' => $dto->s_cargo,
            's_materno' => $dto->s_materno,
            's_paterno' => $dto->s_paterno,
            's_nombres' => $dto->s_nombres,
            's_observacion' => $dto->s_observacion,
            's_sexo' => $dto->s_sexo,
            's_telefonos' => $dto->s_telefonos,
            'i_estado' => 1
        ]);
    }

    public function update(Notario $notario, NotarioDto $dto)
    {
        return $notario->update([
            's_tipodoc' => $dto->s_tipodoc,
            's_numdoc' => $dto->s_numdoc,
            's_cargo' => $dto->s_cargo,
            's_materno' => $dto->s_materno,
            's_paterno' => $dto->s_paterno,
            's_nombres' => $dto->s_nombres,
            's_observacion' => $dto->s_observacion,
            's_sexo' => $dto->s_sexo,
            's_telefonos' => $dto->s_telefonos,
        ]);
    }

    public function findById(Notario $notario): Notario
    {
        return $notario;
    }


    public function disabled(Notario $notario): Notario
    {
        return tap($notario)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Notario $notario): Notario
    {
        return tap($notario)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Notario $notario): Notario
    {
        return $this->disabled($notario);
    }
}
