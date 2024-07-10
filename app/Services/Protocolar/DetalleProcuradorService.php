<?php

namespace App\Services\Protocolar;

use App\Dtos\DetalleProcurador\StoreDetalleProcuradorDto;
use App\Dtos\DetalleProcurador\UpdateDetalleProcuradorDto;
use App\Models\Protocolar\DetalleProcurador;


class DetalleProcuradorService
{


    public function __construct(
        protected DetalleProcuradorDocumentService $detalleProcuradorDocumentService
    )
    {
    }


    public function store(StoreDetalleProcuradorDto $dto): DetalleProcurador
    {
        $payload = new DetalleProcurador($dto->toArray());
        $payload->save();
        return $payload;
    }

    public function update(DetalleProcurador $payload, UpdateDetalleProcuradorDto $dto): DetalleProcurador
    {
        $payload->update($dto->toArray());
        return $payload;
    }

    public function finById(string $id): DetalleProcurador|null
    {
        return DetalleProcurador::find($id);
    }

    public function finByIdPresencia(string $id): DetalleProcurador|null
    {
       return DetalleProcurador::where('s_presencia', $id)->first();
    }
}
