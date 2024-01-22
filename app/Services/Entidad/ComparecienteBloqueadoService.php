<?php

namespace App\Services\Entidad;

use Illuminate\Support\Facades\Auth;
use App\Dtos\ComparecienteBloqueado\ComparecienteBloqueadoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\ComparecienteBloqueado;
use App\Models\Entidad\DetalleBloqueado;
use App\Traits\GenerateCode;
use App\Traits\UploadFileStorage;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ComparecienteBloqueadoService
{

    use GenerateCode, UploadFileStorage;
    public function __construct(
        protected DetalleBloqueadoService $detalleBloqueadoService
    )
    {

    }
    public function get(Request $request)
    {
        $filtro = $request->search;
         $comparecientebloqueado = ComparecienteBloqueado::where(function ($query) use ($filtro) {
             $query->Filtros($filtro);
         })
             ->orderBy('s_codigo', 'desc')
             ->with(['referencia', 'condicion', 'personal'])
             ->paginate(5);
         return CollectionResource::collection($comparecientebloqueado);
    }


    public function store(ComparecienteBloqueadoDto $dto): ComparecienteBloqueado
    {
        $date = Carbon::now();
        $file = $this->UploadImageS3($dto->s_ruta);

        $comparecientebloqueado = ComparecienteBloqueado::create([
            's_referencia' => $dto->s_referencia,
            's_numero' => $dto->s_numero,
            's_condicion' => $dto->s_condicion,
            's_observacion' => $dto->s_observacion,
            's_ruta' => $file,
            's_personal' => Auth::user()->s_codigo,
        ]);

        if(sizeof($dto->comparecientes)){
           // $comparecientebloqueado->deleteComparecientes();
            DetalleBloqueado::bootWithParameter($comparecientebloqueado->s_codigo);
            $comparecientebloqueado->comparecientes()->createMany($dto->comparecientes);
        }
        return  $comparecientebloqueado;
    }

    public function update(ComparecienteBloqueado $comparecientebloqueado, ComparecienteBloqueadoDto $dto)
    {
        $date = Carbon::now();
        $file = $this->UploadImageS3($dto->s_ruta);

        $comparecientebloqueado->update([
            's_referencia' => $dto->s_referencia,
            's_numero' => $dto->s_numero,
            'd_fecha_re' => $date->toDateTimeString(),
            's_condicion' => $dto->s_condicion,
            's_observacion' => $dto->s_observacion,
            's_ruta' => $file,
            's_personal' => Auth()->user()->s_codigo
        ]);

        if(sizeof($dto->comparecientes)){
            $comparecientebloqueado->comparecientes()->delete();
            DetalleBloqueado::bootWithParameter($comparecientebloqueado->s_codigo);
            $comparecientebloqueado->comparecientes()->createMany($dto->comparecientes);
        }

        return  $comparecientebloqueado;
    }

    public function findById(ComparecienteBloqueado $comparecientebloqueado): ComparecienteBloqueado
    {
        return ComparecienteBloqueado::with(['comparecientes'])->findOrFail($comparecientebloqueado->s_codigo);
    }


    public function disabled(ComparecienteBloqueado $comparecientebloqueado): ComparecienteBloqueado
    {
        return tap($comparecientebloqueado)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(ComparecienteBloqueado $comparecientebloqueado): ComparecienteBloqueado
    {
        return tap($comparecientebloqueado)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(ComparecienteBloqueado $comparecientebloqueado): ComparecienteBloqueado
    {
        return $this->disabled($comparecientebloqueado);
    }

    public function destroyFile(ComparecienteBloqueado $comparecientebloqueado)
    {
        return tap($comparecientebloqueado)->update([
            's_ruta' => ""
        ]);
    }
}
