<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\DiligenciaFoto\StoreDiligenciaFotoDto;
use App\Http\Controllers\Controller;
use App\Models\ExtraProtocolar\DiligenciaFoto;

class DiligenciaCartaDocumentService extends Controller
{

    public function store(StoreDiligenciaFotoDto $dto): DiligenciaFoto
    {
        return DiligenciaFoto::create($dto->toArray());
    }

    public function update(DiligenciaFoto $diligenciacartaDocument, StoreDiligenciaFotoDto $dto)
    {
        return $diligenciacartaDocument->update($dto->toArray());
    }

    public function findById(DiligenciaFoto $diligenciacartaDocument): DiligenciaFoto
    {
        return $diligenciacartaDocument;
    }

    public function destroy(DiligenciaFoto $diligenciacartaDocument): DiligenciaFoto
    {
        return tap($diligenciacartaDocument)->delete();
    }
}
