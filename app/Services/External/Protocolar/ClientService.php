<?php

namespace App\Services\External\Protocolar;

use App\Dtos\External\Client\StoreClientDto;
use App\Http\Resources\CollectionResource;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Mantenimiento\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Database\Query\Builder;

class ClientService  
{


    public function __construct(protected  TramiteKardexExternalDocumentService $tramiteKardexExternalDocumentService
    )
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $from = $request->from;
        $to = $request->to;
        $data = ClientExternal::MyRecords()
            ->orderBy('id','desc')
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->with(['detalle_kardex','servicio_notarial','files'])
            ->paginate();
        return CollectionResource::collection($data);

    }

    public function getRegisterPublics(int $id)
    {

        return  ClientExternal::MyRecords()
            ->with(['registro_publico','files','servicio_notarial','servicio_registral'])
            ->find($id);
    }


    public function store(StoreClientDto $dto)
    {
        $client = new ClientExternal($dto->toArray());
        $client->save();

        $tipo_doc = TipoDocumento::find($client->tipo_documento); 

        $this->tramiteKardexExternalDocumentService->saveMany($dto->documents, $client->id);
        $destination = ["chrisz.alvaro@gmail.com", "legalcorporativo@notariarodriguez.com", "ricardocuevas329@gmail.com"];

        $documents = $this->tramiteKardexExternalDocumentService->findByKardex($client->id);
         foreach ($destination as $value => $item){

             Mail::send('emails.registerkardex', [ 'client' => $client, 'tipo_doc' => $tipo_doc->s_abrev,  'adjuntos' => $documents], function ($message) use ($item, $documents) {
                 $message->to($item);
                 $message->subject('Nuevo Kardex');

                 foreach ($documents as $adjunto) {
                     $message->attachData(  $contenido = file_get_contents($adjunto['file']) , $adjunto['name'], [
                         'mime' => $adjunto['type'],
                       //  'encoding' => 'base64',
                     ]);
                 }
             });



         }

        return $client;

    }


}
