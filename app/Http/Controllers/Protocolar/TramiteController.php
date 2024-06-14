<?php

namespace App\Http\Controllers\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\Tramite\StoreObervation;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Mantenimiento\TipoDocumento;
use App\Services\Protocolar\TramiteService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;

class TramiteController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected array $permissions = [];

    public function __construct(
        protected TramiteService $service,
    ) {
    }

    public function list(Request $request): JsonResource
    {
        return $this->service->get($request);
    }
    /*
    public function saveObservation(StoreObervation $request) 
    {
            $data = $this->service->saveObservation($request);
            if($data){
               return $this->success($data, "Mensaje Guardado Correctamente");
            }
        
            return  $this->error("Ocurrió un error, Intentelo Nuevamente!");
    }*/
    public function saveObservationExternal(StoreObervation $request)
    {
        $id_kardex =   $request->s_tramite;
        $data = $this->service->saveObservation($request);
        
        $client = ClientExternal::where('kardex',$id_kardex)->first();
        $tipo_doc = TipoDocumento::find($client->tipo_documento);


        // Enviar correo electrónico con todos los documentos adjuntos
        $destination = ["legalcorporativo@notariarodriguez.com", "ricardocuevas329@gmail.com"];
        //$destination = ["jorgeuchofen060892@gmail.com"];
        foreach ($destination as $item) {
            Mail::send('emails.observation', [
                's_observacion' => $data['s_observacion'],
                'client' => $client,
                'tipo_doc' => $tipo_doc->s_abrev,
                'kardex' => $client->detalle_kardex
            ], function ($message) use ($item) {
                $message->to($item);
                $message->subject('Nueva Comentario');
            });
        }
        return $this->success($data, "Comentario Guardada Correctamente");
    }

    public function saveObservationInternal(StoreObervation $request)
    {
        $id_kardex =   $request->s_tramite;
        $data = $this->service->saveObservation($request);
        $client = ClientExternal::where('kardex',$id_kardex)->first();
        $tipo_doc = TipoDocumento::find($client->tipo_documento);
        // Enviar correo electrónico con todos los documentos adjuntos
        $destination = ["jr@rebajatuscuentas.com", "ricardocuevas329@gmail.com"];
        //$destination = ["jorgeuchofen060892@gmail.com"];
        foreach ($destination as $item) {
            Mail::send('emails.observation', [
                's_observacion' => $data['s_observacion'],
                'client' => $client,
                'tipo_doc' => $tipo_doc->s_abrev,
                'kardex' => $client->detalle_kardex
            ], function ($message) use ($item) {
                $message->to($item);
                $message->subject('Nueva Comentario');
            });
        }
        return $this->success($data, "Comentario Guardada Correctamente");
    }

    public function getAllObservationById(string $id)
    {
        return $this->service->getAllObservationById($id);
    }
}
