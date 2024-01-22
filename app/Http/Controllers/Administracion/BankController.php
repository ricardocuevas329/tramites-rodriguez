<?php

namespace App\Http\Controllers\Administracion;

use App\Dtos\Banco\BancoDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\Banco\StoreBancoRequest;
use App\Http\Requests\Administracion\Banco\UpdateBancoRequest;
use App\Models\Administracion\Banco;
use App\Services\Administracion\BancoService;
use App\Traits\{ApiResponser, MiddlewarePermission};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{

   use ApiResponser, MiddlewarePermission;
   protected $permissions = [];
   public function __construct(
       protected BancoService $service
   ) {
       $this->middleware(function ($request, $next) {
           $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
           return $next($request);
       });
   }


   public function list(Request $request)
   {
       $this->verifyPermission($this->permissions, 'Listar Banco');
       return $this->service->get($request);
   }


    public function all()
    {
        return $this->service->getAll();
    }


   public function store(StoreBancoRequest $request)
   {

       $this->verifyPermission($this->permissions, 'Crear Banco');
       $data = $this->service->store(
           BancoDto::fromApiRequest($request)
       );
       return $this->success($data, 'Guardado correctamente!');
   }

   public function update(UpdateBancoRequest $request, Banco $bank)
   {
       $this->verifyPermission($this->permissions, 'Actualizar Banco');
       $data = $this->service->update(
           $bank,
           BancoDto::fromApiRequest($request)
       );

       return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
   }


   public function findById(Banco $bank)
   {
       $this->verifyPermission($this->permissions, 'Actualizar Banco');
       $data = $this->service->findById($bank);
       if ($data) {
           return $this->success($data);
       }

       return $this->error("No se encontraron datos", 422);

   }

   public function disabled(Banco $bank)
   {
       $this->verifyPermission($this->permissions, 'Desactivar Banco');
       $data =  $this->service->disabled($bank);
       if ($data) {
        return $this->success($data, "Desactivado Correctamente!");
       }

   }

   public function enabled(Banco $bank)
   {
       $this->verifyPermission($this->permissions, 'Activar Banco');
       $data =  $this->service->enabled($bank);
       if ($data) {
        return $this->success($data, "Activado Correctamente!");
       }

   }



}
