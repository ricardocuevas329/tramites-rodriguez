<?php

namespace App\Services\Administracion;

use App\Models\Administracion\DepositosDetalle;

class DepositDetailService
{

    public function __construct(

    )
    {
    }


    public function findById(string $id): DepositosDetalle
    {
        return DepositosDetalle::findOrFail($id);
    }

    public function disabled(DepositosDetalle $depositDetail): DepositosDetalle
    {
        return tap($depositDetail)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(DepositosDetalle $depositDetail): DepositosDetalle
    {
        return tap($depositDetail)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(DepositosDetalle $depositDetail): DepositosDetalle
    {
        return $this->disabled($depositDetail);
    }


}
