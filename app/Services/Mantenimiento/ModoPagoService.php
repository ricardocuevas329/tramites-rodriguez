<?php

namespace App\Services\Mantenimiento;

use App\Dtos\ModoPago\ModoPagoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\ModoPago;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class ModoPagoService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $modopago = ModoPago::orderBy('i_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($modopago);
    }


    public function store(ModoPagoDto $dto): ModoPago
    {

        return ModoPago::create([
            's_codigo_pdt' => $dto->s_codigo_pdt,
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
            'i_estado' => 1
        ]);
    }

    public function update(ModoPago $modopago, ModoPagoDto $dto)
    {
        return $modopago->update([
            's_codigo_pdt' => $dto->s_codigo_pdt,
            's_codigo_sbs' => $dto->s_codigo_sbs,
            's_nombre' => $dto->s_nombre,
            's_descripcion' => $dto->s_descripcion,
        ]);
    }

    public function findById(ModoPago $modopago): ModoPago
    {
        return $modopago;
    }


    public function disabled(ModoPago $modopago): ModoPago
    {
        return tap($modopago)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(ModoPago $modopago): ModoPago
    {
        return tap($modopago)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(ModoPago $modopago): ModoPago
    {
        return tap($modopago)->delete();
    }
}
