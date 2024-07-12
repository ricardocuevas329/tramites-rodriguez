<?php

namespace App\Services\Protocolar;

use App\Dtos\DetalleProcuradorDocumento\StoreProcuradorDocumentoDto;
use App\Dtos\DetalleProcuradorDocumento\UpdateDetalleProcuradorDocumentoDto;
use App\Models\Protocolar\DetalleProcuradorDocument;
use App\Traits\UploadFileStorage;


class DetalleProcuradorDocumentService
{

    use UploadFileStorage;

    public function __construct()
    {
    }


    public function store(StoreProcuradorDocumentoDto $dto, int $id_detalle_procurado): DetalleProcuradorDocument
    {
        $payload = new DetalleProcuradorDocument([
            'id_detalle_procurador' => $id_detalle_procurado, ...$dto->toArray()
        ]);
        $payload->save();
        return $payload;
    }

    public function saveMany(array|null $documents, int $id_detalle_procurado): bool
    {
        $folder = 'procuradores-documents';
        if ($documents && count($documents)) {
            foreach ($documents as $k => $item) {
                if (isset($item['base64'])) {
                    $payload = $this->store(
                        new StoreProcuradorDocumentoDto(
                            file: $this->UploadFilesS3($item['base64'], $folder, $item['type']),
                            name: $item['name'],
                            size: $item['size'],
                            type: $item['type'],
                        ),
                        $id_detalle_procurado,
                    );
                    $payload->save();
                }
            }

            return true;
        }

        return false;
    }


    public function update(DetalleProcuradorDocument $payload, UpdateDetalleProcuradorDocumentoDto $dto): DetalleProcuradorDocument
    {
        $payload->update($dto->toArray());
        return $payload;
    }

    public function finById(string $id): DetalleProcuradorDocument|null
    {
        return DetalleProcuradorDocument::find($id);
    }
}
