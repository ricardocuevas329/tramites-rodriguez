<?php

namespace App\Http\Controllers\Administracion;

use App\Dtos\RegistroDeposito\FormRegistroDepositoDto;
use App\Dtos\RegistroVenta\StoreRegistrationSaleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\RegistroDeposito\StoreRegistroDepositoRequest;
use App\Http\Requests\Administracion\RegistroDeposito\UpdateRegistroDepositoRequest;
use App\Http\Requests\Administracion\RegistroVenta\StoreRegistroVentaRequest;
use App\Http\Requests\Administracion\RegistroVenta\UpdateRegistroVentaRequest;
use App\Models\Administracion\RegistroDeposito;
use App\Services\Administracion\DepositDetailService;
use App\Services\Administracion\RegistrationSaleService;
use App\Services\Protocolar\KardexService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationSaleController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected RegistrationSaleService $service,
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
        $this->verifyPermission($this->permissions, 'Listar RegistroVenta');
        return $this->service->get($request);
    }

    public function store(StoreRegistroVentaRequest $request)
    {
    
        $this->verifyPermission($this->permissions, 'Crear RegistroVenta');

        if($this->service->findByExistNumSerie($request['sales']['serie'])){
            return $this->error("ya Existe este numero de Serie", 422);
        }
      
        $data = $this->service->store(
            StoreRegistrationSaleDto::fromApiRequest($request)
        );
       
       
        return $this->success($data, 'Registro Venta Guardado correctamente!');
    }

    public function update(UpdateRegistroVentaRequest $request, RegistroDeposito $registerdeposit)
    {

        $this->verifyPermission($this->permissions, 'Actualizar RegistroVenta');

        $data = $this->service->update(
            $registerdeposit,
            StoreRegistrationSaleDto::fromApiRequest($request)
        );

        return $this->error("No se encontraron datos", 422);
       // return $this->success($data, "Bien Hecho, Registro Venta Se actualizó correctamente!");
    }


    public function findById(string $id)
    {

        $this->verifyPermission($this->permissions, 'Actualizar RegistroVenta');
        $data = $this->service->findById($id);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(RegistroDeposito $registerdeposit)
    {

        $this->verifyPermission($this->permissions, 'Desactivar RegistroVenta');
        $data =  $this->service->disabled($registerdeposit);
        if ($data) {
         return $this->success($data, "Desactivado Correctamente!");
        }

    }

    public function enabled(RegistroDeposito $registerdeposit)
    {
        $this->verifyPermission($this->permissions, 'Activar RegistroVenta');
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
