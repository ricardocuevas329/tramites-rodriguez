<?php

namespace App\Http\Controllers\Administracion;

use App\Dtos\Area\AreaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\Area\StoreAreaRequest;
use App\Http\Requests\Administracion\Area\UpdateAreaRequest;
use App\Models\Administracion\Area;
use App\Services\Administracion\AreaService;
use App\Traits\{ApiResponser, MiddlewarePermission};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
   use ApiResponser, MiddlewarePermission;
   protected $permissions = [];
   public function __construct(
       protected AreaService $service
   ) {
       $this->middleware(function ($request, $next) {
           $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
           return $next($request);
       });
   }


   public function list(Request $request)
   {
       $this->verifyPermission($this->permissions, 'Listar Area');
       return $this->service->get($request);
   }

   public function store(StoreAreaRequest $request)
   {
       $this->verifyPermission($this->permissions, 'Crear Area');
       $data = $this->service->store(
           AreaDto::fromApiRequest($request)
       );
       return $this->success($data, 'Guardado correctamente!');
   }

   public function update(UpdateAreaRequest $request, Area $area)
   {
       $this->verifyPermission($this->permissions, 'Actualizar Area');
       $data = $this->service->update(
           $area,
           AreaDto::fromApiRequest($request)
       );

       return $this->success($data, "Bien Hecho, Se actualizó correctamente!");
   }


   public function findById(Area $area)
   {
       $this->verifyPermission($this->permissions, 'Actualizar Area');
       $area = $this->service->findById($area);
       if ($area) {
           return $this->success($area);
       }

       return $this->error("No se encontraron datos", 422);

   }

   public function disabled(Area $area)
   {
       $this->verifyPermission($this->permissions, 'Desactivar Area');
       $area =  $this->service->disabled($area);
       if ($area) {
        return $this->success($area, "Desactivado Correctamente!");
       }

   }

   public function enabled(Area $area)
   {
       $this->verifyPermission($this->permissions, 'Activar Area');
       $area =  $this->service->enabled($area);
       if ($area) {
        return $this->success($area, "Activado Correctamente!");
       }

   }

}
