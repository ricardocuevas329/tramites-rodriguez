<?php

namespace App\Services\Entidad;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use Illuminate\Http\Request;
use App\Http\Resources\CollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientCompanyService
{


    public function __construct(
        protected ClienteService $clienteServiceService,
        protected EmpresaService $empresaServiceService,
    )
    {
    }


    public function search(Request $request): JsonResource
    {
        $filtro = $request->search;
        $client = Cliente::select('s_num_doc', 's_nombres', 's_paterno',  's_materno','s_codigo')->where(function ($query) use ($filtro) {
            return $query->Filters($filtro);
        })->orderBy('s_codigo', 'desc')
            ->active()
            ->limit(2)
            ->get();

        $company = Empresa::select('s_num_doc','s_nombre','s_codigo')->where(function ($query) use ($filtro) {
            return $query->Filters($filtro);
        })->orderBy('s_codigo', 'desc')
            ->active()
            ->limit(2)
            ->get();

      $resultadosCombinados = $client->concat($company);
      return CollectionResource::collection($resultadosCombinados);

        /* $query = DB::select("
          (SELECT s_codigo, concat(s_nombres,' ' ,s_paterno, ' ',s_materno) as nombre_compuesto, s_num_doc
          FROM cliente
          WHERE s_num_doc LIKE '%$filtro%'
          OR CONCAT_WS(' ', COALESCE(s_nombres, ''), COALESCE(s_paterno, ''), COALESCE(s_materno, '')) LIKE '%$filtro%'
          LIMIT 3)
          UNION
          (SELECT s_codigo, s_nombre as nombre_compuesto, s_num_doc
          FROM empresa
          WHERE s_num_doc LIKE '%$filtro%'
         OR CONCAT_WS(' ', COALESCE(s_nombre, '')) LIKE '%$filtro%'
         LIMIT 3); ");
        */


    }


}
