<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\CopiaCertificada\CopiaCertificadaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\CopiaCertificada\StoreCopiaCertificadaRequest;
use App\Http\Requests\ExtraProtocolar\CopiaCertificada\UpdateCopiaCertificadaRequest;
use App\Models\Extraprotocolar\CopiaCertificada;
use App\Services\Extraprotocolar\CertifiedCopyService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class CertifiedCopyController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];
    protected int $max_total_files = 4;

    public function __construct(
        protected CertifiedCopyService         $service,

    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request): JsonResource
    {
        $this->verifyPermission($this->permissions, 'Listar CopiasCerfificadas');
        return $this->service->get($request);
    }


    public function store(StoreCopiaCertificadaRequest $request): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Crear CopiasCerfificadas');
        $data = $this->service->store(
            CopiaCertificadaDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateCopiaCertificadaRequest $request, CopiaCertificada $copy): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar CopiasCerfificadas');

        $data = $this->service->update(
            $copy,
            CopiaCertificadaDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(CopiaCertificada $copy): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Actualizar CopiasCerfificadas');
        $copy = $this->service->findById($copy);
        if ($copy) {
            return $this->success($copy);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(CopiaCertificada $copy): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Desactivar CopiasCerfificadas');
        $copy = $this->service->disabled($copy);
        return $this->success($copy, "Desactivado Correctamente!");
    }

    public function enabled(CopiaCertificada $copy): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Activar CopiasCerfificadas');
        $copy = $this->service->enabled($copy);
        return $this->success($copy, "Activado Correctamente!");
    }

    public function generateDocument(CopiaCertificada $copy)
    {
        $copy = $this->service->generateDocument($copy);
        if ($copy) {
            return $copy;
        }
    }

    public function generateExcel(CopiaCertificada $copy)
    {
        $copy = $this->service->generateExcel($copy);
        if ($copy) {
            return $copy;
        }
    }

    public function generatePDF(CopiaCertificada $copy)
    {
        $copy = $this->service->generatePDF($copy);
        if ($copy) {
            return $copy;
        }
    }



}
