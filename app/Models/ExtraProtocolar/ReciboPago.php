<?php

namespace App\Models\ExtraProtocolar;

use App\Models\Administracion\DocumentoCaja;
use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Recibopago
 *
 * @property string $s_codigo
 * @property string|null $s_facturado
 * @property string|null $s_Atendido
 * @property string|null $s_caja
 * @property string|null $s_anulado
 * @property string|null $s_autorizado
 * @property string|null $s_razon
 * @property Carbon|null $d_anulacion
 * @property string|null $s_tipoDocumento
 * @property string|null $s_numeroSerie
 * @property Carbon|null $d_fecha
 * @property string|null $s_hora
 * @property string|null $s_tipo
 * @property float|null $de_subTotal
 * @property float|null $de_igv
 * @property float|null $de_total
 * @property float|null $de_pagado
 * @property float|null $de_cobre
 * @property Carbon|null $d_fechaVencimiento
 * @property string|null $s_observacion
 * @property string|null $s_doc_modifica_tipo
 * @property string|null $s_doc_modifica_serie
 * @property string|null $s_doc_modifica_numero
 * @property string|null $s_tipo_nota_credito
 * @property string|null $s_codigo_hash
 * @property string|null $s_enviado
 * @property string|null $s_documento
 * @property int|null $i_pago_credito
 * @property string|null $s_serieunica
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class ReciboPago extends Model
{
 
    use GenerateCode;
    protected $table = 'recibopago';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'd_anulacion' => 'datetime',
        'd_fecha' => 'datetime: d/m/Y',
        'de_subTotal' => 'float',
        'de_igv' => 'float',
        'de_total' => 'float',
        'de_pagado' => 'float',
        'de_cobre' => 'float',
        'd_fechaVencimiento' => 'datetime',
        'i_pago_credito' => 'int',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_facturado',
        's_Atendido',
        's_caja',
        's_anulado',
        's_autorizado',
        's_razon',
        'd_anulacion',
        's_tipoDocumento',
        's_numeroSerie',
        'd_fecha',
        's_hora',
        's_tipo',
        'de_subTotal',
        'de_igv',
        'de_total',
        'de_pagado',
        'de_cobre',
        'd_fechaVencimiento',
        's_observacion',
        's_doc_modifica_tipo',
        's_doc_modifica_serie',
        's_doc_modifica_numero',
        's_tipo_nota_credito',
        's_codigo_hash',
        's_enviado',
        's_documento',
        'i_pago_credito',
        's_serieunica',
        'i_estado'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $cod = (new ReciboPago())->generateCode((new ReciboPago())->table, 's_codigo', 12, 'RP');
            $payload->s_codigo = $cod;
            $payload->i_estado = 1;
            $payload->d_fecha = date("Y-m-d");
            $payload->s_hora = date("H:i:s");
          //  $firma->s_atendido = Auth::user()->s_codigo;
        });

    }


    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_serieunica', 'LIKE', '%' . $value . '%')
                ->orWhere('s_numeroSerie', 'LIKE', '%' . $value . '%')
                ->orWhereHas('cliente', function ($qr) use ($value) {
                    return $qr->NombreCompuesto($value);
                })->orWhereHas('empresa', function ($qr) use ($value) {
                    return $qr->where('s_nombre',  'LIKE', '%' . $value . '%');
                });
        }
    }

    public function cliente(): HasOne
    {
        return $this->HasOne(Cliente::class, 's_codigo', 's_facturado')->select('s_codigo','s_nombres');
    }

    public function empresa(): HasOne
    {
        return $this->HasOne(Empresa::class, 's_codigo', 's_facturado')->select('s_codigo','s_nombre');
    }

    public function documento_caja(): HasOne
    {
        return $this->HasOne(DocumentoCaja::class, 's_codigo', 's_tipoDocumento');
    }
}
