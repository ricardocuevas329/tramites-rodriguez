<?php

namespace App\Dtos\PermisoViaje;


use App\Http\Requests\ExtraProtocolar\PermisoViaje\StorePermisoViajeRequest;
use App\Http\Requests\ExtraProtocolar\PermisoViaje\UpdatePermisoViajeRequest;


class PermisoViajeDto
{
    public function __construct(
        public readonly ?string $d_fecha_ret ,
        public readonly ?string $d_fecha_sal ,
        public readonly ?int    $i_numero ,
        public readonly ?int    $i_retorno ,
        public readonly ?int    $i_solo ,
        public readonly ?int    $i_tipo ,
        public readonly ?string $s_edad ,
        public readonly ?string $s_formato ,
        public readonly ?string $s_hijo ,
        public readonly ?string $s_linea,
        public readonly ?string $s_observacion ,
        public readonly ?string $s_ruta ,
        public readonly ?string $s_transporte ,
        public readonly ?array  $acompanantes ,
        public readonly ?array  $participantes ,
        public readonly ?string $con_quien_viaja ,
        public readonly ?array  $files
    )
    {
    }

    public function toArray(): array
    {
        return [
            'd_fecha_ret' => $this->d_fecha_ret ,
            'd_fecha_sal' => $this->d_fecha_sal ,
            'i_numero' => (int)$this->i_numero ,
            'i_retorno' => (int)$this->i_retorno ,
            'i_solo' => (int)$this->i_solo ,
            'i_tipo' => (int)$this->i_tipo ,
            's_edad' => $this->s_edad ,
            's_formato' => $this->s_formato ,
            's_hijo' => $this->s_hijo ,
            's_linea' => $this->s_linea ,
            's_observacion' => $this->s_observacion ,
            's_ruta' => str_replace(" " , "" , $this->s_ruta) ,
            's_transporte' => $this->s_transporte ,
            'acompanantes' => $this->acompanantes ,
            'participantes' => $this->participantes ,
            'con_quien_viaja' => $this->con_quien_viaja ,
            'files' => $this->files ,
        ];
    }

    public static function fromApiRequest(StorePermisoViajeRequest|UpdatePermisoViajeRequest $request): PermisoViajeDto
    {
        return new self(
            d_fecha_ret: $request->validated('d_fecha_ret') ,
            d_fecha_sal: $request->validated('d_fecha_sal') ,
            i_numero: $request->validated('i_numero') ,
            i_retorno: $request->validated('i_retorno') ,
            i_solo: $request->validated('i_solo') ,
            i_tipo: $request->validated('i_tipo') ,
            s_edad: $request->validated('s_edad') ,
            s_formato: $request->validated('s_formato') ,
            s_hijo: $request->validated('s_hijo') ,
            s_linea: $request->validated('s_linea') ,
            s_observacion: $request->validated('s_observacion') ,
            s_ruta: $request->validated('s_ruta') ,
            s_transporte: $request->validated('s_transporte') ,
            acompanantes: $request->validated('acompanantes') ,
            participantes: $request->validated('participantes') ,
            con_quien_viaja: $request->validated('con_quien_viaja') ,
            files: $request->validated('files') ,
        );
    }
}
