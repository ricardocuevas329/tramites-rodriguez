<?php

namespace App\Http\Controllers\Administracion;

use App\Dtos\Accion\AccionDto;
use App\Dtos\RegistroDeposito\FormRegistroDepositoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\Accion\StoreAccionRequest;
use App\Http\Requests\Administracion\Accion\UpdateAccionRequest;
use App\Http\Requests\Administracion\RegistroDeposito\StoreRegistroDepositoRequest;
use App\Http\Requests\Administracion\RegistroDeposito\UpdateRegistroDepositoRequest;
use App\Models\Administracion\Accion;
use App\Models\Administracion\RegistroDeposito;
use App\Services\Administracion\AccionService;
use App\Services\Administracion\DepositDetailService;
use App\Services\Administracion\RegistroDepositoService;
use App\Services\Protocolar\KardexService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationDepositController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected RegistroDepositoService $service,
        protected KardexService $kardexService,
        protected DepositDetailService $depositDetailService,
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar RegistroDeposito');
        return $this->service->get($request);
    }

    public function store(StoreRegistroDepositoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear RegistroDeposito');

        if(!$this->kardexService->exists($request->tipo_kardex, $request->s_kardex)){
            return $this->error("No existe este Numero de Kardex", 422);
        }

        $data = $this->service->store(
            FormRegistroDepositoDto::fromApiRequest($request)
        );
        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateRegistroDepositoRequest $request, RegistroDeposito $registerdeposit)
    {

        $this->verifyPermission($this->permissions, 'Actualizar RegistroDeposito');

        if($this->kardexService->exists($request->tipo_kardex, $request->s_kardex) === false){
            return $this->error("No existe este Numero de Kardex", 422);
        }
        $data = $this->service->update(
            $registerdeposit,
            FormRegistroDepositoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(string $id)
    {

        $this->verifyPermission($this->permissions, 'Actualizar RegistroDeposito');
        $data = $this->service->findById($id);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(RegistroDeposito $registerdeposit)
    {

        $this->verifyPermission($this->permissions, 'Desactivar RegistroDeposito');
        $data =  $this->service->disabled($registerdeposit);
        if ($data) {
         return $this->success($data, "Desactivado Correctamente!");
        }

    }

    public function enabled(RegistroDeposito $registerdeposit)
    {
        $this->verifyPermission($this->permissions, 'Activar RegistroDeposito');
        $data =  $this->service->enabled($registerdeposit);
        if ($data) {
         return $this->success($data, "Activado Correctamente!");
        }

    }


    public function aprove(string $id)
    {
        $data =  $this->service->aprove($id);
        if ($data) {
            return $this->success($data, "Aprobado Correctamente!");
        }

    }

    public function delete_document(int $id_document): JsonResponse
    {
        try {
                $document = $this->depositDetailService->destroy($this->depositDetailService->findById($id_document));
                return $this->success($document, "Documento Eliminado Correctamente!");
        } catch (\Exception $e) {
            return $this->error("Ocurrió un error, Intentelo nuevamente!");

        }
    }
}
