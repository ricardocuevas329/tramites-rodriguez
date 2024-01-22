<?php

namespace App\Services\Protocolar;

use App\Dtos\Kardex\StoreKardexDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Protocolar\Kardex;
use App\Models\Protocolar\TipoKardex;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoKardexService extends Controller
{

    public function __construct(

    )
    {
    }

    public function getActives(): JsonResource
    {
        $data = TipoKardex::orderBy('s_codigo', 'desc')->active()->get();

        return CollectionResource::collection($data);
    }


    public function get(Request $request): JsonResource
    {

        $filtro = $request->search;
        $data = Kardex::orderBy('s_codigo', 'desc')
            ->with(['cliente','empresa','asesor','estado'])
            //->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(5);

        return CollectionResource::collection($data);
    }




    public function store(StoreKardexDto $dto): Kardex
    {
        $kardex = new Kardex($dto->toArray());
        $kardex->save();
        return $kardex;
    }

    public function update(Kardex $kardex, StoreKardexDto $dto): Kardex
    {
        $kardex->update($dto->toArray());
        return $kardex;
    }

    public function findById(Kardex $kardex): Kardex|array
    {
        return Kardex::findOrFail($kardex->s_codigo);
    }


    public function disabled(Kardex $kardex): Kardex
    {
        return tap($kardex)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Kardex $kardex): Kardex
    {
        return tap($kardex)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Kardex $kardex): Kardex
    {
        return $this->disabled($kardex);
    }





}
