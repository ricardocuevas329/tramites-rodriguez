<?php

namespace App\Services\Protocolar;

use App\Dtos\Kardex\StoreKardexDto;
use App\Dtos\Presencias\StorePresenciaDto;
use App\Dtos\Presencias\UpdatePresenciaDto;
use App\Http\Resources\CollectionResource;
use App\Models\Protocolar\Presencia;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresenciaNotarialService
{


    public function __construct()
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $from = $request->from;
        $to = $request->to;
        $data = Presencia::orderBy('s_codigo', 'desc')
            ->with(['contacto_cliente', 'contacto_empresa', 'facturado_cliente', 'facturado_empresa', 'referente_cliente', 'referente_empresa'])
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(10);

        return CollectionResource::collection($data);
    }

    public function store(StorePresenciaDto $dto): Presencia
    {
        $payload = new Presencia($dto->toArray());
        $payload->save();
        return $payload;
    }

    public function update(Presencia $payload, UpdatePresenciaDto $dto): Presencia
    {
        $payload->update($dto->toArray());
        return $payload;
    }

    public function findById(string $id): Presencia|array
    {
        return Presencia::with(['contacto_cliente', 'contacto_empresa', 'facturado_cliente', 'facturado_empresa', 'referente_cliente', 'referente_empresa', 'detalle.asistente'])->findOrFail($id);
    }

}
