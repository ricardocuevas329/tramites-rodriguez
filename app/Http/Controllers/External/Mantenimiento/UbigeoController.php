<?php

namespace App\Http\Controllers\External\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\Distrito;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    use ApiResponser;
    public function __construct()
    {

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



}
