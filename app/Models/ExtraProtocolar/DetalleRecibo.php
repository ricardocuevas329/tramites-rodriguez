<?php

namespace App\Models\ExtraProtocolar;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Class Detallerecibo
 *
 * @property string $s_codigo
 * @property string|null $s_recibo
 * @property string|null $s_referencia
 * @property string|null $s_servicio
 * @property string|null $s_detalle
 * @property float|null $de_precio
 * @property int|null $i_cantidad
 * @property float|null $de_subTotal
 * @property float|null $de_igv
 * @property float|null $de_total
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class DetalleRecibo extends Model
{
    use GenerateCode;
    protected $table = 'detallerecibo';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'de_precio' => 'float',
        'i_cantidad' => 'int',
        'de_subTotal' => 'float',
        'de_igv' => 'float',
        'de_total' => 'float',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_codigo',
        's_recibo',
        's_referencia',
        's_servicio',
        's_detalle',
        'de_precio',
        'i_cantidad',
        'de_subTotal',
        'de_igv',
        'de_total',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $cod = (new DetalleRecibo())->generateCode((new DetalleRecibo())->table, 's_codigo', 12, 'PG');
            $payload->s_codigo = $cod;
            $payload->i_estado = 1;
        });

    }


    public function recibo_pago(): HasOne
    {
        return $this->HasOne(ReciboPago::class, 's_codigo', 's_recibo');
    }
}
