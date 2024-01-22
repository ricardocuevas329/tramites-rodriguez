<?php

namespace App\Models\Protocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Interviniente
 *
 * @property string $s_codigo
 * @property string|null $s_kardex
 * @property int|null $i_grupo
 * @property int|null $i_item
 * @property string|null $s_compareciente
 * @property string|null $s_proceder
 * @property string|null $s_tipo
 * @property Carbon|null $d_fecha
 * @property string|null $s_hora
 * @property string|null $s_personal
 * @property int|null $i_indice
 * @property int|null $i_pdt
 * @property int|null $i_foto
 * @property int|null $i_firma
 * @property Carbon|null $d_fechfirma
 * @property string|null $s_hora_firma
 * @property string|null $s_tomador
 * @property int|null $i_lugar_firma
 * @property string|null $s_lugar_firma
 * @property string|null $s_rol_participacion
 * @property string|null $s_casado
 * @property int|null $i_separacion_bienes
 * @property string|null $s_oficina_reg
 * @property string|null $s_registro
 * @property string|null $s_partida
 * @property int|null $i_inscrito
 * @property string|null $s_representa
 * @property string|null $s_oficina_rep
 * @property string|null $s_registro_rep
 * @property string|null $s_partida_rep
 * @property string|null $s_porcentaje
 * @property string|null $s_origen_fondo
 * @property string|null $s_moneda
 * @property float|null $de_monto
 * @property string|null $s_renta_terc
 * @property string|null $s_casa_enaj
 * @property string|null $s_imp_cero
 * @property string|null $s_ope_1662
 * @property string|null $s_pago_2cat
 * @property string|null $s_operacion
 * @property int|null $i_estado
 *
 * @package App\Models\Interviniente
 */
class Interviniente extends Model
{
    protected $table = 'interviniente';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['compareciente'];
    protected $casts = [
        'i_grupo' => 'int',
        'i_item' => 'int',
        'd_fecha' => 'datetime',
        'i_indice' => 'int',
        'i_pdt' => 'int',
        'i_foto' => 'int',
        'i_firma' => 'int',
        'd_fechfirma' => 'datetime:d/m/Y',
        'i_lugar_firma' => 'int',
        'i_separacion_bienes' => 'int',
        'i_inscrito' => 'int',
        'de_monto' => 'float',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_kardex',
        'i_grupo',
        'i_item',
        's_compareciente',
        's_proceder',
        's_tipo',
        'd_fecha',
        's_hora',
        's_personal',
        'i_indice',
        'i_pdt',
        'i_foto',
        'i_firma',
        'd_fechfirma',
        's_hora_firma',
        's_tomador',
        'i_lugar_firma',
        's_lugar_firma',
        's_rol_participacion',
        's_casado',
        'i_separacion_bienes',
        's_oficina_reg',
        's_registro',
        's_partida',
        'i_inscrito',
        's_representa',
        's_oficina_rep',
        's_registro_rep',
        's_partida_rep',
        's_porcentaje',
        's_origen_fondo',
        's_moneda',
        'de_monto',
        's_renta_terc',
        's_casa_enaj',
        's_imp_cero',
        's_ope_1662',
        's_pago_2cat',
        's_operacion',
        'i_estado'
    ];

    public function getComparecienteAttribute()
    {
        $cliente = Cliente::where('s_codigo', $this->s_compareciente)->active()->first();
        return is_object($cliente) ? $cliente : Empresa::where('s_codigo', $this->s_compareciente)->active()->first();
    }



}
