<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\PermisoViajeDocument\PermisoViajeDocumentDto;
use App\Http\Controllers\Controller;
use App\Models\ExtraProtocolar\PermisoViajeDocument;

class PermisoViajeDocumentService extends Controller
{

    public function store(PermisoViajeDocumentDto $dto): PermisoViajeDocument
    {
        return PermisoViajeDocument::create($dto->toArray());
    }

    public function update(PermisoViajeDocument $permisoviajedocument, PermisoViajeDocumentDto $dto)
    {
        return $permisoviajedocument->update($dto->toArray());
    }

    public function findById(PermisoViajeDocument $permisoviajedocument): PermisoViajeDocument
    {
        return $permisoviajedocument;
    }

    public function find(int $id): PermisoViajeDocument
    {
        return PermisoViajeDocument::find($id);
    }



    public function destroy(PermisoViajeDocument $permisoviajedocument): PermisoViajeDocument
    {
        return tap($permisoviajedocument)->delete();
    }
}
