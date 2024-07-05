<?php

namespace App\Services\Protocolar;

use App\Dtos\DetallePresencias\StoreDetallePresenciaDto;
use App\Models\Protocolar\DetallePresencia;


class DetallePresenciaNotarialService
{


    public function __construct()
    {
    }

    public function store(StoreDetallePresenciaDto $dto): DetallePresencia
    {
        $payload = new DetallePresencia($dto->toArray());
        $payload->save();
        return $payload;
    }



}
