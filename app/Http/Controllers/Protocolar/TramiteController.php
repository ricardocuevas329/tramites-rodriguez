<?php

namespace App\Http\Controllers\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\Tramite\StoreObervation;
use App\Services\Protocolar\TramiteService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



class TramiteController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];


    public function __construct(
        protected TramiteService $service,
    )
    {

    }


    public function list(Request $request): JsonResource 
    {
        return $this->service->get($request);
    }


    public function saveObservation(StoreObervation $request) 
    {
      
            $data = $this->service->saveObservation($request);
            if($data){
               return $this->success($data, "Mensaje Guardado Correctamente");
            }
        
            return  $this->error("Ocurrió un error, Intentelo Nuevamente!");
        

    }
    
    public function getAllObservationById(string $id) 
    {
        return $this->service->getAllObservationById($id);
    }

}
