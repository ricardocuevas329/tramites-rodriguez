<?php

namespace App\Services\Administracion;

use App\Dtos\Banco\BancoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\Banco;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;

class BancoService
{

    use GenerateCode;

    public function get(Request $request)
    {

            $filtro = $request->search;
            $data = Banco::where(function ($query) use ($filtro) {
                $query->filtros($filtro);
            })
            ->orderBy('id_cod', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function getAll()
    {
        $data = Banco::orderBy('s_nombre', 'desc')->active()->get();
        return CollectionResource::collection($data);
    }


    public function store(BancoDto $dto): Banco
    {
        return Banco::create([
            's_cod_pdt' =>  $dto->s_cod_pdt,
            's_cod_cnl' =>  $dto->s_cod_cnl,
            's_nombre' =>  $dto->s_nombre,
            's_abrev' =>  $dto->s_abrev,
            'i_estado' => 1
        ]);
    }

    public function update(Banco $banco, BancoDto $dto)
    {
        return $banco->update([
            's_cod_pdt' =>  $dto->s_cod_pdt,
            's_cod_cnl' =>  $dto->s_cod_cnl,
            's_nombre' =>  $dto->s_nombre,
            's_abrev' =>  $dto->s_abrev,
        ]);
    }

    public function findById(Banco $banco): Banco
    {
        return $banco;
    }


    public function disabled(Banco $banco): Banco
    {
        return tap($banco)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Banco $banco): Banco
    {
        return tap($banco)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Banco $banco): Banco
    {
        return tap($banco)->update([
            'i_estado' => 0,
        ]);
    }
}
