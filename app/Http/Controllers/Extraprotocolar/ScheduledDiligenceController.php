<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Dtos\DiligenciaProgramada\DiligenciaProgramadaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\DiligenciaProgramada\StoreDiligenciaProgramadaRequest;
use App\Services\ExtraProtocolar\DiligenciaCartaService;
use App\Services\ExtraProtocolar\DiligenciaProgramadaService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduledDiligenceController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected DiligenciaProgramadaService $service,

    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function listar(Request $request)
    {
        return $this->service->get($request);
    }

    public function store(StoreDiligenciaProgramadaRequest $request){
        $this->verifyPermission($this->permissions, 'Crear Diligencia');
        $data = $this->service->store(DiligenciaProgramadaDto::fromApiRequest($request));
        return $this->success($data, 'Guardado correctamente!');
    }

    public function getUserMotorized(Request $request){
        return $this->service->getUserMotorized($request);
    }
}
