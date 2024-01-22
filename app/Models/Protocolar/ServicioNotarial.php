<?php


namespace App\Models\Protocolar;

use App\Models\Mantenimiento\Servicio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ServiciosNotariales
 *
 * @property string $s_codigo
 * @property string|null $s_kardex
 * @property int|null $s_tipo_servicio
 * @property string|null $s_servicio
 * @property int|null $i_cantidad
 * @property float|null $de_precio
 * @property float|null $de_total
 * @property int|null $i_estado
 * @property Carbon|null $d_fecha_reg
 *
 * @package App\Models
 */
class ServicioNotarial extends Model
{
    protected $table = 'servicios_notariales';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        's_tipo_servicio' => 'int',
        'i_cantidad' => 'int',
        'de_precio' => 'float',
        'de_total' => 'float',
        'i_estado' => 'int',
        'd_fecha_reg' => 'datetime'
    ];

    protected $fillable = [
        's_codigo',
        's_kardex',
        's_tipo_servicio',
        's_servicio',
        'i_cantidad',
        'de_precio',
        'de_total',
        'i_estado',
        'd_fecha_reg'
    ];

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }

    public function scopeNotarial($query)
    {
        return $query->where('s_tipo_servicio', 0)->active();
    }

    public function scopeRegistral($query)
    {
        return $query->where('s_tipo_servicio', 1)->active();
    }

    public function servicio(): HasOne
    {
        return $this->HasOne(Servicio::class, 's_codigo', 's_servicio');
    }

}
