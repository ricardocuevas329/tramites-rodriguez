<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\TipoCambio;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeRateController extends Controller
{
    use ApiResponser, MiddlewarePermission;
    protected $permissions = [];
    public function __construct(

    ) {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }


    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar TipoCambio');
        $filtro = $request->search;
        $tipocambio = TipoCambio::where(function ($query) use ($filtro) {
            $query->dfecha($filtro);
        })
            ->orderBy('d_fecha_reg', 'desc')
            ->paginate(5);
        return CollectionResource::collection($tipocambio);
    }

    public function store(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Crear TipoCambio');
        $request->validate([
            'de_compra' => 'required|min:2|max:5',
            'de_venta' => 'required|min:2|max:5',
        ]);

        $tipocambio = new TipoCambio();
        $tipocambio->de_compra =  $request->de_compra;
        $tipocambio->de_venta =  $request->de_venta;
        $tipocambio->d_fecha =  date('Y-m-d');
        $tipocambio->s_hora =  date('H:i:s');
        $tipocambio->i_estado = 1;
        $tipocambio->save();
        return $this->success($tipocambio, 'Guardado correctamente');
    }


    public function update(Request $request, $id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoCambio');
        $request->validate([
            'de_compra' => 'required|min:2|max:5',
            'de_venta' => 'required|min:2|max:5',
        ]);

        $tipocambio = TipoCambio::find($id);
        $tipocambio->de_compra =  $request->de_compra;
        $tipocambio->de_venta =  $request->de_venta;
        $tipocambio->save();
        return $this->success($tipocambio, 'Actualizado correctamente');
    }

    public function findById($id)
    {
        $this->verifyPermission($this->permissions, 'Actualizar TipoCambio');
        $tipocambio =  TipoCambio::find($id);
        if ($tipocambio) {
            return $this->success($tipocambio);
        } else {
            return $this->error("no se encontraron datos", 422);
        }
    }

    public function disabled($id)
    {
        $this->verifyPermission($this->permissions, 'Desactivar TipoCambio');
        $tipocambio =  TipoCambio::find($id);
        $tipocambio->i_estado = 0;
        $tipocambio->save();
        return $this->success($tipocambio, "Desactivado Correctamente!");
    }

    public function enabled($id)
    {
        $this->verifyPermission($this->permissions, 'Activar TipoCambio');
        $tipocambio = TipoCambio::find($id);
        $tipocambio->i_estado = 1;
        $tipocambio->save();
        return $this->success($tipocambio, "Activado Correctamente!");
    }
}
