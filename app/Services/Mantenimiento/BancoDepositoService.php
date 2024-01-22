<?php

namespace App\Services\Mantenimiento;

use App\Dtos\BancoDeposito\BancoDepositoDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\BancoDeposito;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class BancoDepositoService extends Controller
{

    use GenerateCode;


    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = BancoDeposito::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('i_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(BancoDepositoDto $dto): BancoDeposito
    {

        return BancoDeposito::create([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_contable' => $dto->s_contable,
            's_tipo' => $dto->s_tipo,
            'i_estado' => 1
        ]);
    }

    public function update(BancoDeposito $bancodeposito, BancoDepositoDto $dto)
    {
        return $bancodeposito->update([
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            's_contable' => $dto->s_contable,
            's_tipo' => $dto->s_tipo,
        ]);
    }

    public function findById(BancoDeposito $bancodeposito): BancoDeposito
    {
        return $bancodeposito;
    }


    public function disabled(BancoDeposito $bancodeposito): BancoDeposito
    {
        return tap($bancodeposito)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(BancoDeposito $bancodeposito): BancoDeposito
    {
        return tap($bancodeposito)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(BancoDeposito $bancodeposito): BancoDeposito
    {
        return tap($bancodeposito)->delete();
    }
}
