<?php

namespace App\Dtos\ReciboPago;
class StoreReciboPagoDto
{
    public function __construct(
        public readonly ?string $d_anulacion,
        public readonly ?string $d_fecha,
        public readonly ?string $d_fechaVencimiento,
        public readonly ?string $de_cobre,
        public readonly ?string $de_igv,
        public readonly ?string $de_pagado,
        public readonly ?string $de_subTotal,
        public readonly ?string $de_total,
        public readonly ?int    $i_pago_credito,
        public readonly ?string $s_anulado,
        public readonly ?string $s_Atendido,
        public readonly ?string $s_autorizado,
        public readonly ?string $s_caja,
        public readonly ?string $s_codigo,
        public readonly ?string $s_codigo_hash,
        public readonly ?string $s_doc_modifica_numero,
        public readonly ?string $s_doc_modifica_serie,
        public readonly ?string $s_doc_modifica_tipo,
        public readonly ?string $s_documento,
        public readonly ?string $s_enviado,
        public readonly ?string $s_facturado,
        public readonly ?string $s_hora,
        public readonly ?string $s_numeroSerie,
        public readonly ?string $s_observacion,
        public readonly ?string $s_razon,
        public readonly ?string $s_serieunica,
        public readonly ?string $s_tipo,
        public readonly ?string $s_tipo_nota_credito,
        public readonly ?string $s_tipoDocumento,
    )
    {
    }

    public function toArray()
    {
        return [
            'd_anulacion' => $this->d_anulacion,
            'd_fecha' => $this->d_fecha,
            'd_fechaVencimiento' => $this->d_fechaVencimiento,
            'de_cobre' => $this->de_cobre,
            'de_igv' => $this->de_igv,
            'de_pagado' => $this->de_pagado,
            'de_subTotal' => $this->de_subTotal,
            'de_total' => $this->de_total,
            'i_pago_credito' => $this->i_pago_credito,
            's_anulado' => $this->s_anulado,
            's_Atendido' => $this->s_Atendido,
            's_autorizado' => $this->s_autorizado,
            's_caja' => $this->s_caja,
            's_codigo' => $this->s_codigo,
            's_codigo_hash' => $this->s_codigo_hash,
            's_doc_modifica_numero' => $this->s_doc_modifica_numero,
            's_doc_modifica_serie' => $this->s_doc_modifica_serie,
            's_doc_modifica_tipo' => $this->s_doc_modifica_tipo,
            's_documento' => $this->s_documento,
            's_enviado' => $this->s_enviado,
            's_facturado' => $this->s_facturado,
            's_hora' => $this->s_hora,
            's_numeroSerie' => $this->s_numeroSerie,
            's_observacion' => $this->s_observacion,
            's_razon' => $this->s_razon,
            's_serieunica' => $this->s_serieunica,
            's_tipo' => $this->s_tipo,
            's_tipo_nota_credito' => $this->s_tipo_nota_credito,
            's_tipoDocumento' => $this->s_tipoDocumento,
        ];
    }

}
