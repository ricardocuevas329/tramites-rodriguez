<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Dtos\BancoDeposito\BancoDepositoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\BancoDeposito\StoreBancoDepositoRequest;
use App\Http\Requests\Mantenimiento\BancoDeposito\UpdateBancoDepositoRequest;
use App\Models\Mantenimiento\BancoDeposito;
use App\Services\Mantenimiento\BancoDepositoService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankDepositController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected BancoDepositoService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar BancoDeposito');
        return $this->service->get($request);
    }

    public function store(StoreBancoDepositoRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear BancoDeposito');
        $data = $this->service->store(
            BancoDepositoDto::fromApiRequest($request)
        );

        return $this->success($data, 'Guardado correctamente!');
    }

    public function update(UpdateBancoDepositoRequest $request, BancoDeposito $bancodeposito)
    {
        $this->verifyPermission($this->permissions, 'Actualizar BancoDeposito');
        $data = $this->service->update(
            $bancodeposito,
            BancoDepositoDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(BancoDeposito $bancodeposito)
    {
        $this->verifyPermission($this->permissions, 'Actualizar BancoDeposito');
        $bancodeposito = $this->service->findById($bancodeposito);
        if ($bancodeposito) {
            return $this->success($bancodeposito);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(BancoDeposito $bancodeposito)
    {
        $this->verifyPermission($this->permissions, 'Desactivar BancoDeposito');
        $bancodeposito =  $this->service->disabled($bancodeposito);
        if ($bancodeposito) {
            return $this->success($bancodeposito, "Desactivado Correctamente!");
        }
    }

    public function enabled(BancoDeposito $bancodeposito)
    {
        $this->verifyPermission($this->permissions, 'Activar BancoDeposito');
        $bancodeposito =  $this->service->enabled($bancodeposito);
        if ($bancodeposito) {
            return $this->success($bancodeposito, "Activado Correctamente!");
        }
    }
}
