<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Http\Controllers\Controller;
use App\Models\Extraprotocolar\CopiaCertificada;
use App\Models\ExtraProtocolar\OficinaRegistral;
use App\Services\Extraprotocolar\RegistationOfficeService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class SignatureRepresentationController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];

    public function __construct(
        protected RegistationOfficeService         $service,

    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function findById(CopiaCertificada $copy): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Actualizar OficinaRegistral');
        $copy = $this->service->findById($copy);
        if ($copy) {
            return $this->success($copy);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(OficinaRegistral $copy): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Desactivar OficinaRegistral');
        $copy = $this->service->disabled($copy);
        return $this->success($copy, "Desactivado Correctamente!");
    }

    public function enabled(OficinaRegistral $copy): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Activar OficinaRegistral');
        $copy = $this->service->enabled($copy);
        return $this->success($copy, "Activado Correctamente!");
    }

    public function generateDocument(OficinaRegistral $copy)
    {
        $copy = $this->service->generateDocument($copy);
        if ($copy) {
            return $copy;
        }
    }

    public function generateExcel(OficinaRegistral $copy)
    {
        $copy = $this->service->generateExcel($copy);
        if ($copy) {
            return $copy;
        }
    }

    public function generatePDF(OficinaRegistral $copy)
    {
        $copy = $this->service->generatePDF($copy);
        if ($copy) {
            return $copy;
        }
    }

    public function ActiveBySignature(): JsonResource
    {
        return $this->service->getActiveBySignature();
    }




}
