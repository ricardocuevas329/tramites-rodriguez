<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Departamento;
use App\Models\Mantenimiento\Distrito;
use App\Models\Mantenimiento\Provincia;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UbigeoController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar Ubigeo');

        $filtro = $request->search;
        $ubigeo = Distrito::where(function ($query) use ($filtro) {
            $query->nombre($filtro);
        })->orderBy('s_distrito', 'asc')
            ->paginate(5);

        return CollectionResource::collection($ubigeo);
    }

    public function searchUbigeo(Request $request)
    {
        $filtro = $request->search;
        $ubigeo = Distrito::where(function ($query) use ($filtro) {
            $query->nombre($filtro);
        })->orderBy('s_distrito', 'asc')
            ->limit(5)
            ->get();

        return CollectionResource::collection($ubigeo);
    }


    public function store(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Crear Ubigeo');

        $departamento = $request->departamento['_value'];
        $provincias = $request->provincias['_value'];
        $distritos = $request->distritos['_value'];
        $request->validate([]);

        $dp = new Departamento();
        $dp->s_codigo =  $departamento['s_codigo'];
        $dp->s_departamento =  $departamento['s_departamento'];
        $dp->save();
        foreach ($provincias as $item) {

            $provincia = new Provincia();
            $provincia->s_codigo =  $item['s_codigo'];
            $provincia->s_provincia =  $item['s_provincia'];
            $provincia->save();
        }

        foreach ($distritos as $item) {

            $distrito = new Distrito();
            $distrito->s_codigo =  $item['s_codigo'];
            $distrito->s_distrito =  $item['distrito'];
            $distrito->save();
        }

        return $this->success([], 'Guardado correctamente');
    }

    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Ubigeo');

        $departamento = $request->departamento['_value'];
        $provincias = $request->provincias['_value'];
        $distritos = $request->distritos['_value'];

        $request->validate([]);

        $departamento = new Departamento();
        $departamento->s_codigo =  $departamento['s_codigo'];
        $departamento->s_departamento =  $departamento['s_departamento'];
        $departamento->save();
        foreach ($provincias as $item) {

            $provincia = new Provincia();
            $provincia->s_codigo =  $item['s_codigo'];
            $provincia->s_provincia =  $item['s_provincia'];
            $provincia->save();
        }

        foreach ($distritos as $item) {

            $distrito = new Distrito();
            $distrito->s_codigo =  $item['s_codigo'];
            $distrito->s_distrito =  $item['distrito'];
            $distrito->save();
        }

        return $this->success([], 'Guardado correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar Ubigeo');

        $departamento =  Departamento::find($id);
        if ($departamento) {
            return $this->success($departamento);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }
}
