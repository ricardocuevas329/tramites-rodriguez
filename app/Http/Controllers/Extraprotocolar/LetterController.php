<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\Carta\CartaDto;
use App\Dtos\DiligenciaCarta\DiligenciaCartaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\Carta\StoreCartaRequest;
use App\Http\Requests\ExtraProtocolar\Carta\UpdateObservationCartaRequest;
use App\Http\Requests\ExtraProtocolar\DiligenciaCarta\StoreDiligenciaCartaRequest;
use App\Models\Extraprotocolar\Carta;
use App\Models\ExtraProtocolar\DiligenciaCarta;
use App\Services\ExtraProtocolar\CartaService;
use App\Services\Mantenimiento\DetalleRangoService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class LetterController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected CartaService $service,
        protected DetalleRangoService $serviceDetalle,

    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Carta');
        return $this->service->get($request);
    }

    public function search(Request $request)
    {

        return $this->serviceDetalle->searchPrecioDistrito($request);
    }

    public function storeDiligence(StoreDiligenciaCartaRequest $request){
        $data = $this->service->storeDiligencia(
            DiligenciaCartaDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function findDiligenciaById($letterdiligence)
    {

        $data = $this->service->findDiligenciaById($letterdiligence);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function store(StoreCartaRequest $request){
        $this->verifyPermission($this->permissions, 'Crear Carta');
        $data = $this->service->store(
            CartaDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function updateObservation(UpdateObservationCartaRequest $request, Carta $letter)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Carta');
        $data = $this->service->updateObservation(
            $letter,
            $request
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }

    public function updateProgramation($request, Carta $letter)
    {

        $data = $this->service->updateProgramation(
            $letter,
            $request
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }

    public function findById(Carta $letter)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Carta');
        $data = $this->service->findById($letter);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function generateDocument(Carta $letter)
    {
        $data =  $this->service->generateDocument($letter);
        if ($data) {
            return $data;
        }
    }

    public function generateExcel(Carta $letter)
    {
        $data =  $this->service->generateExcel($letter);
        if ($data) {
            return $data;
        }
    }

    public function generatePDF(Carta $letter)
    {
        $data =  $this->service->generatePDF($letter);
        if ($data) {
            return $data;
        }
    }

    public function generateOrder(Carta $letter)
    {
        $data =  $this->service->generateOrden($letter);
        if ($data) {
            return $data;
        }
    }
}
