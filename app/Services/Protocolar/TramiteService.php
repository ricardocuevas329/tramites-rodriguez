<?php

namespace App\Services\Protocolar;

use App\Http\Requests\Protocolar\Tramite\StoreObervation;
use App\Http\Resources\CollectionResource;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Protocolar\HistorialTramite;
use App\Models\Mantenimiento\Situacion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TramiteService
{


    public function __construct()
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $from = $request->from;
        $to = $request->to;
        $data = ClientExternal::orderBy('id', 'desc')
            ->Filtros($filtro)
            ->with(['detalle_kardex', 'servicio_notarial', 'files', 'files_notaria', 'files_testimonio'])
            ->paginate(10);

        $iCodigosSituacion = Situacion::pluck('i_codigo')->toArray();

        foreach ($data->items() as $item) {
            if (!is_null($item->detalle_kardex)) {
                $i_estadonota = intval($item->detalle_kardex->i_estadonota);

                if (in_array($i_estadonota, $iCodigosSituacion)) {
                    $situacionDetalle = Situacion::where('i_codigo', $i_estadonota)->first();
                    $item->situacion_detalle = $situacionDetalle;
                }
            }
        }

        return CollectionResource::collection($data);
    }

    public function getById(string $id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        return ClientExternal::with(['detalle_kardex', 'servicio_notarial', 'files', 'files_notaria'])->find($id);
    }

    public function saveObservation(StoreObervation $request): HistorialTramite
    {

        $tramite = $request->s_tramite;
        $observacion = $request->s_observacion;
        $data = new HistorialTramite();
        $data->s_tramite  = $tramite;
        $data->i_tipo =  0;
        $data->s_personal = Auth::user()->s_codigo;
        $data->s_observacion =  $observacion;
        $data->save();
        return $data;
    }


    public function getAllObservationById(string $id): JsonResource
    {
        $data = HistorialTramite::where('s_tramite', $id)->with(['personal', 'cliente', 'empresa'])->paginate(50);
        return CollectionResource::collection($data);
    }
}
