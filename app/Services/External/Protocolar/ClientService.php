<?php

namespace App\Services\External\Protocolar;

use App\Dtos\External\Client\StoreClientDto;
use App\Http\Resources\CollectionResource;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Mantenimiento\TipoDocumento;
use App\Models\Entidad\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Database\Query\Builder;
use Carbon\Carbon;

class ClientService
{
    public function __construct(
        protected  TramiteKardexExternalDocumentService $tramiteKardexExternalDocumentService
    ) {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $from = $request->from;
        $to = $request->to;
        $data = ClientExternal::MyRecords()
            ->orderBy('id', 'desc')
            ->where(fn (Builder $query) => $query->Filtros($filtro))
            ->with(['detalle_kardex', 'servicio_notarial', 'files', 'files_notaria'])
            ->paginate();
        return CollectionResource::collection($data);
    }

    public function getCliente(Request $request): JsonResource
    {
        try {
            $codigo = $request->codigo;
            $cliente = Cliente::where('s_codigo', $codigo)->first();

            // Verifica si el cliente fue encontrado.
            if (!$cliente) {
                return new JsonResource(['mensaje' => 'Cliente no encontrado']);
            }

            // Calcula la edad a partir de la fecha de nacimiento.
            $fechaNacimiento = Carbon::parse($cliente->d_fecha_nac);
            $edad = $fechaNacimiento->diffInYears(Carbon::now());

            // Añade la edad al objeto del cliente.
            $cliente->edad = $edad;

            // Devuelve los detalles del cliente como recurso JSON.
            return new JsonResource($cliente);
        } catch (\Exception $e) {
            // Maneja cualquier error que pueda ocurrir durante la búsqueda.
            return new JsonResource(['error' => 'Error al obtener detalles del cliente']);
        }
    }
    public function getRegisterPublics(int $id)
    {
        return  ClientExternal::MyRecords()
            ->with(['registro_publico', 'files', 'servicio_notarial', 'servicio_registral'])
            ->find($id);
    }

    public function store(StoreClientDto $dto)
    {
        // Crear un nuevo cliente externo y guardarlo en la base de datos
        $client = new ClientExternal($dto->toArray());
        $client->save();

        // Obtener el tipo de documento asociado al cliente
        $tipo_doc = TipoDocumento::find($client->tipo_documento);

        // Guardar los documentos relacionados con el cliente
        $this->tramiteKardexExternalDocumentService->saveMany($dto->documents, $client->id);

        // Destinatarios del correo electrónico
        $destination = ["chrisz.alvaro@gmail.com", "legalcorporativo@notariarodriguez.com", "ricardocuevas329@gmail.com"];

        // Obtener la lista de documentos relacionados con el cliente
        $documents = $this->tramiteKardexExternalDocumentService->findByKardex($client->id);
        // Enviar correos electrónicos a los destinatarios
        foreach ($destination as $item) {
            Mail::send('emails.registerkardex', [
                'client' => $client,
                'tipo_doc' => $tipo_doc->s_abrev,
                'adjuntos' => $documents
            ], function ($message) use ($item, $documents) {
                $message->to($item);
                $message->subject('Nuevo Kardex');

                // Adjuntar documentos al correo electrónico
                foreach ($documents as $adjunto) {
                    $message->attachData(file_get_contents($adjunto['file']), $adjunto['name'], [
                        'mime' => $adjunto['type'],
                    ]);
                }
            });
        }
        return $client;
    }
}
