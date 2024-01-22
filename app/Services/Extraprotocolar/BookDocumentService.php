<?php

namespace App\Services\Extraprotocolar;

use App\Dtos\LibroDocument\StoreLibroDocumentDto;
use App\Http\Controllers\Controller;
use App\Models\ExtraProtocolar\LibroDocument;

class BookDocumentService extends Controller
{

    public function store(StoreLibroDocumentDto $dto): LibroDocument
    {
        return LibroDocument::create($dto->toArray());
    }

    public function update(LibroDocument $permisoviajedocument, StoreLibroDocumentDto $dto)
    {
        return $permisoviajedocument->update($dto->toArray());
    }

    public function findById(LibroDocument $permisoviajedocument): LibroDocument
    {
        return $permisoviajedocument;
    }

    public function find(int $id): LibroDocument
    {
        return LibroDocument::find($id);
    }




    public function destroy(LibroDocument $permisoviajedocument): LibroDocument
    {
        return tap($permisoviajedocument)->delete();
    }
}
