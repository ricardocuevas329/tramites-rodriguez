<?php

namespace App\Dtos\CopiaCertificada;

use App\Http\Requests\ExtraProtocolar\CopiaCertificada\StoreCopiaCertificadaRequest;
use App\Http\Requests\ExtraProtocolar\CopiaCertificada\UpdateCopiaCertificadaRequest;

class CopiaCertificadaDto
{
    public function __construct(
        public readonly ?string $d_fecha_legalizado,
        public readonly ?int    $i_copias,
        public readonly ?int    $i_inicial,
        public readonly ?string $s_cargo,
        public readonly ?string $s_consta,
        public readonly ?string $s_descripcion,
        public readonly ?string $s_folios,
        public readonly ?string $s_legalizado,
        public readonly ?string $s_libros,
        public readonly ?string $s_numero_reg,
        public readonly ?string $s_observacion,
        public readonly ?string $s_pertenece,

    )
    {
    }

    public function toArray()
    {
        return [
            'd_fechaLegalizado' => $this->d_fecha_legalizado,
            'i_copias' => $this->i_copias,
            'i_inicial' => $this->i_inicial,
            's_cargo' => $this->s_cargo,
            's_consta' => $this->s_consta,
            's_descripcion' => $this->s_descripcion,
            's_folios' => $this->s_folios,
            's_legalizado' => $this->s_legalizado,
            's_libros' => $this->s_libros,
            's_numero_reg' => $this->s_numero_reg,
            's_observacion' => $this->s_observacion,
            's_pertenece' => $this->s_pertenece,
            'd_fechaLegalizado' => $this->d_fecha_legalizado,
            's_numeroReg' => $this->s_numero_reg,

        ];
    }

    public static function fromApiRequest(StoreCopiaCertificadaRequest|UpdateCopiaCertificadaRequest $request): CopiaCertificadaDto
    {
        return new self(
            d_fecha_legalizado: $request->validated('d_fecha_legalizado'),
            i_copias: $request->validated('i_copias'),
            i_inicial: $request->validated('i_inicial'),
            s_cargo: $request->validated('s_cargo'),
            s_consta: $request->validated('s_consta'),
            s_descripcion: $request->validated('s_descripcion'),
            s_folios: $request->validated('s_folios'),
            s_legalizado: $request->validated('s_legalizado'),
            s_libros: $request->validated('s_libros'),
            s_numero_reg: $request->validated('s_numero_reg'),
            s_observacion: $request->validated('s_observacion'),
            s_pertenece: $request->validated('s_pertenece'),

        );
    }

}
