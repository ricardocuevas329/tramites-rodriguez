<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\ModoPago\ModoPagoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\ModoPago\StoreModoPagoRequest;
use App\Http\Requests\Mantenimiento\ModoPago\UpdateModoPagoRequest;
use App\Models\Mantenimiento\ModoPago;
use App\Services\Mantenimiento\ModoPagoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentModeController extends Controller
{

    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected ModoPagoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar ModoPago');
        return $this->service->get($request);
    }

    public function store(StoreModoPagoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear ModoPago');
        $data = $this->service->store(
            ModoPagoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateModoPagoRequest $request, ModoPago $modopago)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ModoPago');
        $data = $this->service->update(
            $modopago,
            ModoPagoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(ModoPago $modopago)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ModoPago');
        $modopago = $this->service->findById($modopago);
        if ($modopago) {
            return $this->success($modopago);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(ModoPago $modopago)
    {
        $this->verifyPermission($this->permissions, 'Desactivar ModoPago');
        $modopago =  $this->service->disabled($modopago);
        if ($modopago) {
            return $this->success($modopago, "Desactivado Correctamente!");
        }
    }

    public function enabled(ModoPago $modopago)
    {
        $this->verifyPermission($this->permissions, 'Activar ModoPago');
        $modopago =  $this->service->enabled($modopago);
        if ($modopago) {
            return $this->success($modopago, "Activado Correctamente!");
        }
    }
}
