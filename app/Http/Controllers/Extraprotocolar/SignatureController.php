<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\Firma\StoreFirmaDto;
use App\Dtos\Firma\StoreFirmaUploadDto;
use App\Dtos\FirmaRepresentacion\SignatureRepresentationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\Firma\StoreRegistroFirmaRequest;
use App\Http\Requests\ExtraProtocolar\Firma\StoreSignatureRepresentationRequest;
use App\Http\Requests\ExtraProtocolar\Firma\StoreStoreFirmaUploadRequest;
use App\Http\Requests\ExtraProtocolar\Firma\UpdateRegistroFirmaRequest;
use App\Http\Requests\ExtraProtocolar\FirmaRepresentacion\StoreStoreFirmaRepresentacionRequest;
use App\Models\ExtraProtocolar\Firma;
use App\Services\ExtraProtocolar\FirmaService;
use App\Services\Extraprotocolar\SignatureDocumentService;
use App\Services\Extraprotocolar\SignatureRepresentationService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignatureController extends Controller
{
    use ApiResponser, MiddlewarePermission;

    protected $permissions = [];

    public function __construct(
        protected FirmaService                   $service,
        protected SignatureRepresentationService $signatureRepresentationService,
        protected SignatureDocumentService $signatureDocumentService

    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar RegistroFirmas');
        return $this->service->get($request);
    }

    public function store(StoreRegistroFirmaRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear RegistroFirmas');
        $data = $this->service->store(
            StoreFirmaDto::fromApiRequest($request)
        );
        return $this->success($data, 'Firma Guardado correctamente!');
    }

    public function storeSignatureRepresentation(StoreStoreFirmaRepresentacionRequest $request)
    {
        $data = $this->signatureRepresentationService->store(
            SignatureRepresentationDto::fromApiRequest($request)
        );

        return $this->success($data, 'Firma Guardado correctamente!');
    }


    public function update(UpdateRegistroFirmaRequest $request, Firma $signature): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar RegistroFirmas');
        $data = $this->service->update(
            $signature,
            StoreFirmaDto::fromApiRequest($request)
        );

        return $this->success($data, 'Firma Actualizada correctamente!');
    }

    public function upload_signature(StoreStoreFirmaUploadRequest $request, Firma $signature)
    {
        $data = $this->service->upload_signature($signature, StoreFirmaUploadDto::fromApiRequest($request) );
        return $this->success($data, 'Foto de Firma Adjuntado correctamente!');
    }

    public function remove_document_signature(Firma $signature)
    {
        $data = $this->service->remove_document_signature($signature);
        return $this->success($data, 'Foto de Firma Eliminado correctamente!');
    }



    public function findById(Firma $signature)
    {
        $this->verifyPermission($this->permissions, 'Actualizar RegistroFirmas');
        $data = $this->service->findById($signature);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }


    public function findSignatureRepresentationById(string $id_signature)
    {
        return $this->service->findSignatureRepresentationById($id_signature);
    }


    public function generateDocument(Firma $signature)
    {
        $data = $this->service->generateDocument($signature);
        if ($data) {
            return $data;
        }
    }


    public function delete_document(int $id_document): JsonResponse
    {
        try {
            if ($this->service->countFiles($this->signatureDocumentService->find($id_document)->id_firma)) {
                $document = $this->service->deleteDocument($id_document);
                return $this->success($document, "Documento Eliminado Correctamente!");
            } else {
                return $this->error("No está permitido eliminar todos los Documentos!");
            }
        } catch (\Exception $e) {
            return $this->error("Ocurrió un error, Intentelo nuevamente!");

        }
    }

}
