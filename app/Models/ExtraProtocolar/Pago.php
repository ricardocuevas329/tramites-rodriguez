<?php


namespace App\Models\ExtraProtocolar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 *
 * @property string $s_codigo
 * @property string|null $s_recibo
 * @property Carbon|null $d_fecha
 * @property string|null $s_medioPago
 * @property string|null $s_detalle
 * @property string|null $s_banco
 * @property Carbon|null $d_fecha_ope
 * @property string|null $s_numero
 * @property string|null $s_moneda
 * @property string|null $s_tipocambio
 * @property float|null $de_importe
 * @property float|null $de_cobre
 * @property Carbon|null $d_fecha_cheque
 * @property int|null $i_estado
 *
 * @package App\Models\ExtraProtocolar
 */
class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'd_fecha' => 'datetime',
        'd_fecha_ope' => 'datetime',
        'de_importe' => 'float',
        'de_cobre' => 'float',
        'd_fecha_cheque' => 'datetime',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_recibo',
        'd_fecha',
        's_medioPago',
        's_detalle',
        's_banco',
        'd_fecha_ope',
        's_numero',
        's_moneda',
        's_tipocambio',
        'de_importe',
        'de_cobre',
        'd_fecha_cheque',
        'i_estado'
    ];
}
