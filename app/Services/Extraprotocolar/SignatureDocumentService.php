<?php

namespace App\Services\Extraprotocolar;

use App\Dtos\FirmaDocument\StoreFirmaDocumentDto;
use App\Http\Controllers\Controller;
use App\Models\ExtraProtocolar\FirmaDocument;

class SignatureDocumentService extends Controller
{

    public function store(StoreFirmaDocumentDto $dto): FirmaDocument
    {
        return FirmaDocument::create($dto->toArray());
    }

    public function update(FirmaDocument $signatureDocumentService, StoreFirmaDocumentDto $dto)
    {
        return $signatureDocumentService->update($dto->toArray());
    }

    public function findById(FirmaDocument $signatureDocumentService): FirmaDocument
    {
        return $signatureDocumentService;
    }

    public function find(int $id): FirmaDocument
    {
        return FirmaDocument::find($id);
    }




    public function destroy(FirmaDocument $signatureDocumentService): FirmaDocument
    {
        return tap($signatureDocumentService)->delete();
    }
}
