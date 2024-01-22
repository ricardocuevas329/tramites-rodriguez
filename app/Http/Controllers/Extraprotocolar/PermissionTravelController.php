<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\PermisoViaje\PermisoViajeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\PermisoViaje\StorePermisoViajeRequest;
use App\Http\Requests\ExtraProtocolar\PermisoViaje\UpdatePermisoViajeRequest;
use App\Models\ExtraProtocolar\PermisoViaje;
use App\Services\ExtraProtocolar\PermisoViajeDocumentService;
use App\Services\Extraprotocolar\PermisoViajeService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class PermissionTravelController extends Controller
{

    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];
    protected int $max_total_files = 4;

    public function __construct(
        protected PermisoViajeService         $service,
        protected PermisoViajeDocumentService $permisoViajeDocumentService
    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request): JsonResource
    {
        $this->verifyPermission($this->permissions, 'Listar PermisoViaje');
        return $this->service->get($request);
    }

    public function listPermissionTravelExternal(Request $request): JsonResource
    {
        return $this->service->getExterno($request);
    }


    public function store(StorePermisoViajeRequest $request): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Crear PermisoViaje');

        if (count($request->get('participantes')) == 0) {
            return $this->error("Agregue al menos 1 Participante!");
        }

        if ($request->get('files')) {
            if (count($request->get('files')) > $this->max_total_files) {
                return $this->error("Solo está permitido adjuntar $this->max_total_files Documentos!");
            }
        }

        $data = $this->service->store(
            PermisoViajeDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdatePermisoViajeRequest $request, PermisoViaje $permissiontravel): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar PermisoViaje');

        if (count($request->get('participantes')) == 0) {
            return $this->error("Seleccione al menos 1 Participante!");
        }

        if ($request->get('files')) {
            if (count($request->get('files')) > $this->max_total_files) {
                return $this->error("Solo está permitido adjuntar $this->max_total_files Documentos!");
            }
        }
        $data = $this->service->update(
            $permissiontravel,
            PermisoViajeDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(PermisoViaje $permissiontravel): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Actualizar PermisoViaje');
        $data = $this->service->findById($permissiontravel);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(PermisoViaje $permissiontravel): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Desactivar PermisoViaje');
        $data = $this->service->disabled($permissiontravel);
        return $this->success($data, "Desactivado Correctamente!");
    }

    public function enabled(PermisoViaje $permissiontravel): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Activar PermisoViaje');
        $data = $this->service->enabled($permissiontravel);
        return $this->success($data, "Activado Correctamente!");
    }

    public function generateDocument(PermisoViaje $permissiontravel)
    {
        $data = $this->service->generateDocument($permissiontravel);
        if ($data) {
            return $data;
        }
    }

    public function generateExcel(PermisoViaje $permissiontravel)
    {
        $data = $this->service->generateExcel($permissiontravel);
        if ($data) {
            return $data;
        }
    }

    public function generatePDF(PermisoViaje $permissiontravel)
    {
        $data = $this->service->generatePDF($permissiontravel);
        if ($data) {
            return $data;
        }
    }


    public function delete_document(int $id_document): JsonResponse
    {
        try {
            if ($this->service->countFiles($this->permisoViajeDocumentService->find($id_document)->id_permiso_viaje)) {
                $document = $this->service->deleteDocument($id_document);
                return $this->success($document, "Documento Eliminado Correctamente!");
            } else {
                return $this->error("No está permitido eliminar todos los Documentos!");
            }
        } catch (\Exception $e) {
            return $this->error("Ocurrió un error, Intentelo nuevamente!");

        }
    }


}
