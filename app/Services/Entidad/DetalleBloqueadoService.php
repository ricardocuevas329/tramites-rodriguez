<?php

namespace App\Services\Entidad;

use App\Dtos\DetalleBloqueado\DetalleBloqueadoDto;
use App\Models\Entidad\DetalleBloqueado;
use App\Traits\GenerateCode;


class DetalleBloqueadoService
{

    use GenerateCode;



    public function store(DetalleBloqueadoDto $dto): DetalleBloqueado
    {
        $tableName = (new DetalleBloqueado())->getTable();
        $merge = array_merge( $dto->toArray(),
        [
          's_codigo' => $this->generateCode($tableName, 's_codigo', 12, 'DB')
        ]);
        $detalleBloqueado = new DetalleBloqueado($merge);
        $detalleBloqueado->save();
        return $detalleBloqueado;
    }

    public function update(DetalleBloqueado  $detallebloaqueado, DetalleBloqueadoDto $dto): DetalleBloqueado
    {
        $merge = array_merge($dto->toArray());
        $detallebloaqueado->update($merge);
        return $detallebloaqueado;
    }


}
