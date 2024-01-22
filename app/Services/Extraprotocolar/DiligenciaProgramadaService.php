<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\DiligenciaProgramada\DiligenciaProgramadaDto;
use App\Http\Controllers\Controller;
use App\Models\Extraprotocolar\Carta;
use App\Models\ExtraProtocolar\DiligenciaProgramada;
use App\Services\Entidad\ClienteService;
use App\Traits\GenerateCode;


class DiligenciaProgramadaService extends Controller
{

    use GenerateCode;

    public function __construct(
        protected ClienteService $clienteService,

    )
    {
    }

    public function store(DiligenciaProgramadaDto $dto)
    {
        $diligenciaprogramada = DiligenciaProgramada::create([
            'd_fecha_programacion' => $dto->d_fecha_programacion,
            's_num_carta' => $dto->s_num_carta,
            's_observacion' => $dto->s_observacion,
            's_motorizado' => $dto->s_motorizado,
        ]);

        Carta::where('s_numcarta', $dto->s_num_carta)->update(['i_situacion' => 7]);

        return $diligenciaprogramada;
    }

    public function delivered(int $s_num_carta)
    {
        $diligenciaProgramada = DiligenciaProgramada::where('s_num_carta', $s_num_carta)
            ->where('i_estado', 1)
            ->first();
        $diligenciaProgramada->i_estado = 2;
        $diligenciaProgramada->save();

    }

}
