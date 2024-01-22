<?php

namespace App\Http\Controllers\External\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\TipoDocumento;
use App\Traits\ApiResponser;

class DocumentTypeController extends Controller
{
    use ApiResponser;
    public function __construct()
    {

    }

    public function actives()
    {
        $data = TipoDocumento::activos()
            ->orderBy('s_nombre', 'asc')
            ->get();

        return CollectionResource::collection($data);
    }


}
