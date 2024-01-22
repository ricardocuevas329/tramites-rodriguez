<?php

namespace App\Http\Controllers\External\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Services\Mantenimiento\NacionalidadService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NationalityController extends Controller
{

    use ApiResponser;
    public function __construct(
        protected NacionalidadService $service
    ) {

    }

    public function listarAll(Request $request)
    {
        return $this->service->getAll($request);
    }
}
