<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Abogado\AbogadoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Abogado\StoreAbogadoRequest;
use App\Http\Requests\Entidad\Abogado\UpdateAbogadoRequest;
use App\Models\Entidad\Abogado;
use App\Services\Entidad\AbogadoService;
use App\Services\Entidad\ClientCompanyService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientCompanyController extends Controller
{
    use ApiResponser;
    public function __construct(
        protected ClientCompanyService $service,
    ) {
    }

    public function search(Request $request)
    {
        return $this->service->search($request);
    }




}
