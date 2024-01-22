<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\DocumentoVenta\DocumentoVentaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\DocumentoVenta\StoreDocumentoVentaRequest;
use App\Http\Requests\Mantenimiento\DocumentoVenta\UpdateDocumentoVentaRequest;
use App\Models\Mantenimiento\DocumentoVenta;
use App\Services\Mantenimiento\DocumentoVentaService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentSaleController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected DocumentoVentaService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar DocumentoVenta');
        return $this->service->get($request);
    }

    public function store(StoreDocumentoVentaRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear DocumentoVenta');
        $data = $this->service->store(
            DocumentoVentaDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateDocumentoVentaRequest $request, DocumentoVenta $documentoventa)
    {
        $this->verifyPermission($this->permissions, 'Actualizar DocumentoVenta');
        $data = $this->service->update(
            $documentoventa,
            DocumentoVentaDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(DocumentoVenta $documentoventa)
    {
        $this->verifyPermission($this->permissions, 'Actualizar DocumentoVenta');
        $documentoventa = $this->service->findById($documentoventa);
        if ($documentoventa) {
            return $this->success($documentoventa);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(DocumentoVenta $documentoventa)
    {
        $this->verifyPermission($this->permissions, 'Desactivar DocumentoVenta');
        $documentoventa =  $this->service->disabled($documentoventa);
        if ($documentoventa) {
            return $this->success($documentoventa, "Desactivado Correctamente!");
        }
    }

    public function enabled(DocumentoVenta $documentoventa)
    {
        $this->verifyPermission($this->permissions, 'Activar DocumentoVenta');
        $documentoventa =  $this->service->enabled($documentoventa);
        if ($documentoventa) {
            return $this->success($documentoventa, "Activado Correctamente!");
        }
    }
}
