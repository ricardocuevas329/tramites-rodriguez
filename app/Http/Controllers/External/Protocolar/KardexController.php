<?php

namespace App\Http\Controllers\External\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\External\Kardex\SearchKardexRequest;
use App\Http\Requests\External\Kardex\StoreKardexAsignationRequest;
use App\Services\External\Protocolar\KardexService;
use App\Services\External\Protocolar\TramiteKardexExternalDocumentService;
use App\Services\Protocolar\TipoKardexService;
use App\Traits\ApiResponser;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Mantenimiento\TipoDocumento;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KardexController extends Controller
{
    use ApiResponser;

    public function __construct(
        protected TipoKardexService $tipoKardexService,
        protected KardexService     $kardexService,
        protected TramiteKardexExternalDocumentService $tramiteKardexExternalDocumentService
    ) {
    }

    public function searchKardex(SearchKardexRequest $request): JsonResource
    {
        return $this->kardexService->getKardex($request);
    }

    public function searchCodigo(SearchKardexRequest $request): JsonResource
    {
        return $this->kardexService->getCodigo($request);
    }

    public function listActives(): JsonResource
    {
        return $this->tipoKardexService->getActives();
    }

    public function listParticipants(Request $request)
    {
        $kardex = $request->kardex;
        return $this->kardexService->getParticipants($kardex);
    }

    public function saveAsignation(StoreKardexAsignationRequest $request)
    {

        if (!$this->kardexService->existsKardex($request)) {
            return $this->error("Kardex no Existe!!");
        }

        $data = $this->kardexService->saveAsignation($request);
        $destination = ["jr@rebajatuscuentas.com", "ricardocuevas329@gmail.com"];

        foreach ($destination as $item) {
            Mail::send('emails.kardex_assignation', [
                'kardex_data' => $data['detalle_kardex']
            ], function ($message) use ($item) {
                $message->to($item);
                $message->subject('Nuevo Kardex Asignado');
            });
        }
        return $this->success($data, "Kardex Asigando Correctamente!!");
    }

    public function saveDocumentExternal(Request $request)
    {

        $documents = $request->documents;
        $id_kardex = (int) $request->id_kardex;

        if (!count($documents)) {
            return $this->error("Agregue Documentos");
        }

        $client = ClientExternal::where('id',$id_kardex)->first();
        $tipo_doc = TipoDocumento::find($client->tipo_documento);


        $this->tramiteKardexExternalDocumentService->saveMany($documents, $client->id);

        $destination = ["legalcorporativo@notariarodriguez.com", "ricardocuevas329@gmail.com"];
        $attachedDocuments = [];

        foreach ($documents as $document) {
            if (isset($document['base64']) && isset($document['name']) && isset($document['type'])) {
                $attachedDocuments[] = [
                    'name' => $document['name'],
                    'file' => $document['base64'],
                    'type' => $document['type'],
                ];
            }
        }

        foreach ($destination as $item) {
            Mail::send('emails.registerkardexnewdocument', [
                'client' => $client,
                'tipo_doc' => $tipo_doc->s_abrev,
                'adjuntos' => $attachedDocuments,
                'kardex' => $client->detalle_kardex
            ], function ($message) use ($item, $attachedDocuments) {
                $message->to($item);
                $message->subject('Se subio un nuevo documento');

                // Adjuntar todos los documentos al correo electrónico
                foreach ($attachedDocuments as $adjunto) {
                    $message->attachData(base64_decode($adjunto['file']), $adjunto['name'], [
                        'mime' => $adjunto['type'],
                    ]);
                }
            });
        }
        return $this->success($attachedDocuments, "Documentos guardados y enviados por correo correctamente!!");
    }

    public function saveDocumentInternal(Request $request)
    {

        $documents = $request->documents;
        $id_kardex = (int) $request->id_kardex;

        if (!count($documents)) {
            return $this->error("Agregue Documentos");
        }

        $client = ClientExternal::find($id_kardex);
        $tipo_doc = TipoDocumento::find($client->tipo_documento);


        $this->tramiteKardexExternalDocumentService->saveMany($documents, $client->id);

        $destination = ["jr@rebajatuscuentas.com", "ricardocuevas329@gmail.com"];
        $attachedDocuments = [];

        foreach ($documents as $document) {

            if (isset($document['base64']) && isset($document['name']) && isset($document['type'])) {
                $attachedDocuments[] = [
                    'name' => $document['name'],
                    'file' => $document['base64'],
                    'type' => $document['type'],
                ];
            }
        }

        foreach ($destination as $item) {
            Mail::send('emails.registerkardexnewdocument', [
                'client' => $client,
                'tipo_doc' => $tipo_doc->s_abrev,
                'adjuntos' => $attachedDocuments,
                'kardex' => $client->detalle_kardex
            ], function ($message) use ($item, $attachedDocuments) {
                $message->to($item);
                $message->subject('Se subio un nuevo documento');

                foreach ($attachedDocuments as $adjunto) {
                    $message->attachData(base64_decode($adjunto['file']), $adjunto['name'], [
                        'mime' => $adjunto['type'],
                    ]);
                }
            });
        }
        return $this->success($attachedDocuments, "Documentos guardados y enviados por correo correctamente!!");
    }
}
