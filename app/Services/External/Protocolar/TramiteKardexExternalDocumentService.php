<?php

namespace App\Services\External\Protocolar;

use App\Dtos\External\TramiteKardexExternalDocument\StoreTramiteKardexExternalDocumentDto;
use App\Http\Controllers\Controller;
use App\Models\External\Protocolar\TramiteKardexExternalDocument;
use App\Traits\UploadFileStorage;

class TramiteKardexExternalDocumentService extends Controller
{

    use  UploadFileStorage;

    public function store(StoreTramiteKardexExternalDocumentDto $dto): TramiteKardexExternalDocument
    {
        return TramiteKardexExternalDocument::create($dto->toArray());
    }

    public function update(TramiteKardexExternalDocument $payload, StoreTramiteKardexExternalDocumentDto $dto)
    {
        return $payload->update($dto->toArray());
    }

    public function findById(TramiteKardexExternalDocument $payload): TramiteKardexExternalDocument
    {
        return $payload;
    }


    public function findByKardex(int $id)
    {
        return TramiteKardexExternalDocument::where('id_kardex',$id)->get();
    }


    public function find(int $id): TramiteKardexExternalDocument
    {
        return TramiteKardexExternalDocument::find($id);
    }


    public function saveMany($payload  , int $id_kardex): bool
    {
        if (count($payload)) {
            foreach ($payload as $item => $value){
                if(!isset($value['id_kardex'])){
                    $this->store(
                        new StoreTramiteKardexExternalDocumentDto(
                            id_kardex: (int) $id_kardex,
                            file: $this->UploadFilesS3($value['base64'], "tramite-external", $value['type']),
                            tipo_archivo: $value['documentType'],
                            name: $value['name'],
                            type: $value['type'],
                            size: (int) $value['size']
                        )
                    );
                }
            }
            return true;
        }

        return false;
    }


    public function destroy(TramiteKardexExternalDocument $payload): TramiteKardexExternalDocument
    {
        return tap($payload)->delete();
    }
}
