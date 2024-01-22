<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento\TipoDocumento;
use App\Services\Mantenimiento\TipoDocumentoService;
use App\Traits\ApiResponser;
use App\Traits\GenerateCode;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeDocumentController extends Controller
{
    use ApiResponser, GenerateCode, MiddlewarePermission;

    protected $permissions = [];

    public function __construct(
        protected TipoDocumentoService $service
    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar TipoDocumento');
        return $this->service->get($request);
    }

    public function actives()
    {
        return $this->service->actives();
    }

    public function documentClient()
    {
        return $this->service->getClientDocument();
    }

    public function documentCompany()
    {
        return $this->service->getCompanyDocument();
    }

    public function store(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Crear TipoDocumento');
        $request->validate([
            's_nombre' => 'unique:tipo_docu,s_nombre|required|min:2|max:50',
            's_codigo_sbs' => 'required|min:1|max:2',
            's_cod_cnl' => 'required|min:1|max:2',
            's_abrev' => 'required|min:2|max:7',
            //'i_digitos' => 'between:1,999',
            's_tipoFe' => 'required|min:1|max:1',
        ]);

        $tipodocumento = new TipoDocumento();
        $tipodocumento->s_codigo = $this->generateCode('tipo_docu', 's_codigo', 5, 'TD');
        $tipodocumento->s_codigo_sbs = $request->s_codigo_sbs;
        $tipodocumento->s_cod_cnl = $request->s_cod_cnl;
        $tipodocumento->s_nombre = $request->s_nombre;
        $tipodocumento->s_abrev = $request->s_abrev;
        $tipodocumento->i_digitos = (int)$request->i_digitos;
        $tipodocumento->s_tipoFe = $request->s_tipoFe;
        $tipodocumento->i_estado = 1;
        $tipodocumento->save();

        return $this->success($tipodocumento, 'Guardado correctamente');
    }

    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoDocumento');
        $request->validate([
            's_nombre' => 'unique:tipo_docu,s_nombre,' . $id . ',s_codigo' . '|required|min:2|max:50',
            's_codigo_sbs' => 'required|min:1|max:2',
            's_cod_cnl' => 'required|min:1|max:2',
            's_abrev' => 'required|min:2|max:7',
            //'i_digitos' => 'between:1,999',
            's_tipoFe' => 'required|min:1|max:1',
        ]);

        $tipodocumento = TipoDocumento::find($id);
        $tipodocumento->s_codigo_sbs = $request->s_codigo_sbs;
        $tipodocumento->s_cod_cnl = $request->s_cod_cnl;
        $tipodocumento->s_nombre = $request->s_nombre;
        $tipodocumento->s_abrev = $request->s_abrev;
        $tipodocumento->i_digitos = (int)$request->i_digitos;
        $tipodocumento->s_tipoFe = $request->s_tipoFe;
        $tipodocumento->save();
        return $this->success($tipodocumento, 'Actualizado correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoDocumento');
        $tipodocumento = TipoDocumento::find($id);
        if ($tipodocumento) {
            return $this->success($tipodocumento);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }

    public function disabled($id)
    {
        $this->verifyPermission($this->permissions, 'Desactivar TipoDocumento');
        $tipodocumento = TipoDocumento::find($id);
        $tipodocumento->i_estado = 0;
        $tipodocumento->save();
        return $this->success($tipodocumento, "Desactivado Correctamente!");
    }

    public function enabled($id)
    {
        $this->verifyPermission($this->permissions, 'Activar TipoDocumento');
        $tipodocumento = TipoDocumento::find($id);
        $tipodocumento->i_estado = 1;
        $tipodocumento->save();
        return $this->success($tipodocumento, "Activado Correctamente!");
    }
}
