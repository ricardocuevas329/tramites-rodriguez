<?php

namespace App\Services\Mantenimiento;

use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TipoDocumentoService
{
    public function get(Request $request): JsonResource
    {

        $filtro = $request->search;
        $data = TipoDocumento::where(function ($query) use ($filtro) {
            $query->nombre($filtro)
                ->abreviatura($filtro);
        })
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function actives(): JsonResource
    {
        $data = TipoDocumento::activos()
            ->orderBy('s_nombre', 'asc')
            ->get();

        return CollectionResource::collection($data);
    }


    public function getClientDocument(): JsonResource
    {
        $cod = ['TD001', 'TD003', 'TD004', 'TD005', 'TD006', 'TD007', 'TD008',
            'TD009', 'TD010', 'TD011', 'TD012', 'TD013', 'TD015', 'TD016', 'TD018'];

        $data = TipoDocumento::where('i_estado', 1)
            ->whereIn('s_codigo', $cod)
            ->get();

        return CollectionResource::collection($data);
    }

    public function getCompanyDocument(): JsonResource
    {
        $cod = ['TD002', 'TD017', 'TD014'];
        $data =  TipoDocumento::where('i_estado', 1)
            ->whereIn('s_codigo', $cod)
            ->get();
        return CollectionResource::collection($data);
    }

    public function findByCod(string $codigo): TipoDocumento
    {
        return TipoDocumento::where('i_estado', 1)->find($codigo);
    }

    public function findCodRuc(): TipoDocumento
    {
        $rucs = ['R.U.C', 'RUC', 'ruc', 'r.u.c'];
        return TipoDocumento::where('i_estado', 1)->whereIn('s_abrev', $rucs)->first();
    }


    public function findExistDocument(string $codigo, array $searchs): bool
    {
        $coincidencias = TipoDocumento::where('s_codigo', $codigo)
            ->where('i_estado', 1)
            ->whereIn('s_abrev', $searchs)
            ->get();
        if ($coincidencias->isNotEmpty()) {
            return true;
        }
        return false;
    }


    public function searchExistNameByCod(string $abrev, string $search): bool
    {

        $posicion = strpos($abrev, $search);
        if ($posicion !== false) {
            return true;
        } else {
            return false;
        }
    }


}
