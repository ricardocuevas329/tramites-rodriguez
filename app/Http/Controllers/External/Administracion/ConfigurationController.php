<?php

namespace App\Http\Controllers\External\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Configuracion;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use App\Traits\UploadFileStorage;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ConfigurationController extends Controller
{
    use ApiResponser,UploadFileStorage, MiddlewarePermission;
    protected $permissions = [];
    protected $id_user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id_user = Auth::user()?->s_codigo;
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function listar(Request $request)
    {
        $config = Configuracion::where('i_estado', 1)->first();
        return  $this->success($config);
    }

    public function store(Request $request)
    {

        $this->verifyPermission($this->permissions, 'Crear ConfiguracionGeneral');
        $request->validate([
            's_empresa' => 'required|min:3|max:100',
            's_direccion' => 'required|min:3|max:150',
            's_descripcion' => 'required|min:3|max:200',
        ]);


        $config = new Configuracion();
        $config->s_empresa = $request->s_empresa;
        $config->s_direccion =  $request->s_direccion;
        $config->s_ruta_logo = $request->file ? $this->UploadImageStorage($request->file, 'logo', 'png') : '';
        $config->d_fecha_registro = date("Y-m-d");
        $config->s_hora_registro = date("H:i:s");
        $config->s_responsable = $this->id_user;
        $config->s_descripcion = $request->s_descripcion;
        $config->i_estado = 1;
        $config->save();
        return $this->success($config, 'Configuracion Guardada correctamente');
    }

    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ConfiguracionGeneral');
        $request->validate([
            's_empresa' => 'required|min:3|max:100',
            's_direccion' => 'required|min:3|max:150',
            's_descripcion' => 'required|min:3|max:200',
        ]);

        $config = Configuracion::find($id);
        $config->s_empresa = $request->s_empresa;
        $config->s_direccion =  $request->s_direccion;

        if($request->file){
            $config->s_ruta_logo = $this->UploadImageStorage($request->file, 'logo', 'png');
        }
        $config->d_fecha_registro =  new DateTime();
        $config->d_fecha_registro = date("Y-m-d");
        $config->s_hora_registro = date("H:i:s");
        $config->s_responsable = Auth::user()?->s_codigo;
        $config->s_descripcion = $request->s_descripcion;
        $config->i_estado = 1;
        $config->save();
        return $this->success($config, 'Configuracion Actualizada correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ConfiguracionGeneral');
        $config = Configuracion::find($id);
        if ($config) {
            return $this->success($config);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }


}
