<?php

namespace App\Http\Controllers\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\Tramite\StoreObervation;
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
    public function saveObservation(StoreObervation $request)
    {
        $data = $this->service->saveObservation($request);
        //dd($data);
        // Enviar correo electrónico con todos los documentos adjuntos
        $destination = ["chrisz.alvaro@gmail.com", "legalcorporativo@notariarodriguez.com", "ricardocuevas329@gmail.com"];
        //$destination = ["jorgeuchofen060892@gmail.com"];
        foreach ($destination as $item) {
            Mail::send('emails.observation', [
                's_observacion' => $data['s_observacion'],
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
