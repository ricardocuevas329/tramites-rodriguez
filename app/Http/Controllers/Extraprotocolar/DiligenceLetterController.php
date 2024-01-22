<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\DiligenciaProgramada\DiligenciaProgramadaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\DiligenciaProgramada\StoreDiligenciaProgramadaRequest;
use App\Services\ExtraProtocolar\DiligenciaCartaService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiligenceLetterController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected DiligenciaCartaService $service,

    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Diligencia');
        return $this->service->get($request);
    }

    public function getUserMotorized(Request $request){
        return $this->service->getUserMotorized($request);
    }

    public function findDiligenciaById($id)
    {

        $diligenciaCarta = $this->service->findDiligenciaById($id);
        if ($diligenciaCarta) {
            return $this->success($diligenciaCarta);
        }
        return $this->error("No se encontraron datos", 422);
    }


}
