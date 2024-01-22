<?php

namespace App\Dtos\Libro;

class LibroDto
{
    public function __construct(
        public readonly ?string $d_fecha_apertura,
        public readonly ?string $d_fecha_cierre,
        public readonly ?string $d_fecha_entrega,
        public readonly ?int    $i_estado,
        public readonly ?int    $i_imprime,
        public readonly ?string $i_sisgen,
        public readonly ?int    $i_tipopago,
        public readonly ?string $s_actonotarial,
        public readonly ?string $s_atendido,
        public readonly ?int    $s_cantidad,
        public readonly ?string $s_cliente,
        public readonly ?string $s_codigo,
        public readonly ?string $s_denominacion,
        public readonly ?string $s_empresa,
        public readonly ?string $s_entregado,
        public readonly ?string $s_facturar,
        public readonly ?string $s_folios,
        public readonly ?string $s_forma,
        public readonly ?string $s_hora_apertura,
        public readonly ?string $s_hora_entrega,
        public readonly ?int    $s_libro,
        public readonly ?string $s_numero_libro,
        public readonly ?string $s_observacion,
        public readonly ?string $s_personal_entrega,
        public readonly ?string $s_precio,
        public readonly ?int    $s_registro,
        public readonly ?string $s_representante,
        public readonly ?string $s_tipolibro,
    )
    {
    }

    public function toArray()
    {
        return [
            'd_fecha_apertura' => $this->d_fecha_apertura,
            'd_fecha_cierre' => $this->d_fecha_cierre,
            'd_fecha_entrega' => $this->d_fecha_entrega,
            'i_estado' => $this->i_estado,
            'i_imprime' => $this->i_imprime,
            'i_sisgen' => $this->i_sisgen,
            'i_tipopago' => $this->i_tipopago,
            's_actonotarial' => $this->s_actonotarial,
            's_atendido' => $this->s_atendido,
            's_cantidad' => $this->s_cantidad,
            's_cliente' => $this->s_cliente,
            's_codigo' => $this->s_codigo,
            's_denominacion' => $this->s_denominacion,
            's_empresa' => $this->s_empresa,
            's_entregado' => $this->s_entregado,
            's_facturar' => $this->s_facturar,
            's_folios' => $this->s_folios,
            's_forma' => $this->s_forma,
            's_hora_apertura' => $this->s_hora_apertura,
            's_hora_entrega' => $this->s_hora_entrega,
            's_libro' => $this->s_libro,
            's_numero_libro' => $this->s_numero_libro,
            's_observacion' => $this->s_observacion,
            's_personal_entrega' => $this->s_personal_entrega,
            's_precio' => $this->s_precio,
            's_registro' => $this->s_registro,
            's_representante' => $this->s_representante,
            's_tipolibro' => $this->s_tipolibro,
        ];
    }


}
