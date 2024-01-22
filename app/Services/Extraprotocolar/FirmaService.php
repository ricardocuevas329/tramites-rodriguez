<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\Firma\StoreFirmaDto;
use App\Dtos\Firma\StoreFirmaUploadDto;
use App\Dtos\FirmaDocument\StoreFirmaDocumentDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\ExtraProtocolar\Firma;
use App\Models\ExtraProtocolar\FirmaDocument;
use App\Models\ExtraProtocolar\FirmaRepresentacion;
use App\Services\Entidad\ClienteService;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentPermisoViajePDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentFirma;
use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class FirmaService extends Controller
{

    use GenerateDocumentFirma, UploadFileStorage, GenerateDocumentPermisoViajeExcel, GenerateDocumentPermisoViajePDF;

    public function __construct(
        protected ClienteService           $clienteService,
        protected ParticipanteService      $participanteService,
        protected AcompananteService       $acompananteService,
        protected SignatureDocumentService $signatureDocumentService
    )
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $data = Firma::orderBy('s_codigo', 'desc')
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->with(['cliente', 'atendido'])
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(StoreFirmaDto $dto): Firma
    {
        $files = $dto->files;
        $signature = new Firma($dto->toArray());
        $signature->save();
        if ($files && count($files)) {
            foreach ($files as $file => $value) {
                if (isset($value['base64'])) {
                    $folder = 'firma-documents';
                    $this->signatureDocumentService->store(
                        new StoreFirmaDocumentDto(
                            id_firma: $signature->s_codigo,
                            file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                            name: $value['name'],
                            type: $value['type'],
                            size: $value['size'],
                        )
                    );
                }
            }
        }

        return $signature;
    }

    public function update(Firma $signature, StoreFirmaDto $dto): Firma
    {
        $files = $dto->files;
        $signature->update($dto->toArray());
        if ($files && count($files)) {
            foreach ($files as $file => $value) {

                if (isset($value['base64'])) {
                    $folder = 'firma-documents';
                    $this->signatureDocumentService->store(
                        new StoreFirmaDocumentDto(
                            id_firma: $signature->s_codigo,
                            file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                            name: $value['name'],
                            type: $value['type'],
                            size: $value['size'],
                        )
                    );
                }
            }
        }

        return $signature;
    }

    public function upload_signature(Firma $signature, StoreFirmaUploadDto $dto): Firma
    {
        $folder = 'firma-photo';
        $signature->foto_firma =  $this->UploadOnlyFileS3($dto->foto_firma, $folder);
        $signature->save();
        return $signature;

    }

    public function remove_document_signature(Firma $signature): Firma
    {
        $signature->foto_firma =  '';
        $signature->save();
        return $signature;

    }

    public function findById(Firma $signature): Firma|array
    {
        return Firma::with(['cliente', 'atendido', 'files'])->findOrFail($signature->s_codigo);
    }


    public function findSignatureRepresentationById(string $id_signature): JsonResource
    {
        $data = FirmaRepresentacion::with(['cliente'])->active()->where('s_representado', $id_signature)->get();
        return CollectionResource::collection($data);
    }


    public function disabled(Firma $signature): Firma
    {
        return tap($signature)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Firma $signature): Firma
    {
        return tap($signature)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Firma $signature): Firma
    {
        return $this->disabled($signature);
    }

    public function generateDocument(Firma $signature)
    {
        return $this->createDocumentWord($signature);
    }

    public function generateExcel(Firma $signature)
    {
        return $this->exportExcel($signature);
    }

    public function generatePDF(Firma $signature)
    {
        return $this->exportPDF($signature);
    }

    public function countFiles(string $id_signature): bool
    {
        $data = Firma::where('s_codigo', $id_signature)->withCount('files')->first();
        if ($data->files_count == 1) {
            return false;
        }
        return true;
    }

    public function deleteDocument(int $id_document): FirmaDocument
    {
        $document = FirmaDocument::find($id_document);
        return $this->signatureDocumentService->destroy($document);
    }
}
