<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Empresa\EmpresaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Empresa\{StoreEmpresaRequest, UpdateEmpresaRequest};
use App\Models\Entidad\Empresa;
use App\Services\Entidad\EmpresaService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(
        protected EmpresaService $service
    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        return $this->service->get($request);
    }

    public function store(StoreEmpresaRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Empresa');
        if ($this->service->existClient($request->s_num_doc, $request->s_tip_doc)) {
            return $this->error('Empresa ya existe, Registre otro!');
        }
        $data = $this->service->store(
            EmpresaDto::fromApiRequest($request)
        );

        return $this->success($data, 'Empresa Guardado correctamente!');
    }

    public function update(UpdateEmpresaRequest $request, Empresa $company)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Empresa');
        if ($company->s_num_doc != $request->s_num_doc && $this->service->existClient($request->s_num_doc, $request->s_tip_doc)) {
            return $this->error('Empresa ya existe, Registre otro!');
        }
        $data = $this->service->update(
            $company,
            EmpresaDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
    }


    public function findById(Empresa $company)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Empresa');
        $data = $this->service->findById($company);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Empresa $company)
    {

        $this->verifyPermission($this->permissions, 'Desactivar Empresa');
        $data =  $this->service->disabled($company);
        if ($data) {
            return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(Empresa $company)
    {
        $this->verifyPermission($this->permissions, 'Activar Empresa');
        $data =  $this->service->enabled($company);
        if ($data) {
            return $this->success($data, "Activado Correctamente!");
        }
    }

    public function findByRuc(int $ruc)
    {

        $data = $this->service->findByRuc($ruc);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function findByDocument(Request $request)
    {
        $data = $this->service->findByDocument($request);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }
}
