<?php

namespace App\Models\ExtraProtocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Traits\PermissionTravelUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;


/**
 * Class Libro
 *
 * @property int $s_libro
 * @property string|null $s_codigo
 * @property string|null $s_actonotarial
 * @property int|null $s_registro
 * @property Carbon|null $d_fecha_apertura
 * @property string|null $s_hora_apertura
 * @property Carbon|null $d_fecha_cierre
 * @property string|null $s_observacion
 * @property string|null $s_tipolibro
 * @property string|null $s_denominacion
 * @property string|null $s_numero_libro
 * @property string|null $s_forma
 * @property string|null $s_folios
 * @property int|null $s_cantidad
 * @property float|null $s_precio
 * @property int|null $i_tipopago
 * @property string|null $s_cliente
 * @property string|null $s_empresa
 * @property string|null $s_facturar
 * @property string|null $s_representante
 * @property string|null $s_atendido
 * @property string|null $s_personal_entrega
 * @property string|null $s_hora_entrega
 * @property Carbon|null $d_fecha_entrega
 * @property string|null $s_entregado
 * @property int|null $i_imprime
 * @property string|null $i_sisgen
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class Libro extends Model
{
    use PermissionTravelUtils;

    protected $table = 'libros';
    protected $primaryKey = 's_libro';
    public $timestamps = false;
    protected $appends = ['imprime', 'solicitante'];

    protected $casts = [
        's_registro' => 'int',
        'd_fecha_apertura' => 'datetime: d/m/Y',
        //'d_fecha_cierre' => 'datetime: d/m/Y',
        's_cantidad' => 'int',
        's_precio' => 'float',
        'i_tipopago' => 'int',
        'd_fecha_entrega' => 'datetime: d/m/Y',
        'i_imprime' => 'int',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_codigo',
        's_actonotarial',
        's_registro',
        'd_fecha_apertura',
        's_hora_apertura',
        'd_fecha_cierre',
        's_observacion',
        's_tipolibro',
        's_denominacion',
        's_numero_libro',
        's_forma',
        's_folios',
        's_cantidad',
        's_precio',
        'i_tipopago',
        's_cliente',
        's_empresa',
        's_facturar',
        's_representante',
        's_atendido',
        's_personal_entrega',
        's_hora_entrega',
        'd_fecha_entrega',
        's_entregado',
        'i_imprime',
        'i_sisgen',
        'i_estado'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($libro) {
            $libro->s_hora_apertura = date("H:i:s a");
            $libro->d_fecha_apertura = date("Y-m-d");
            $libro->s_atendido = Auth::user()->s_codigo;
            $libro->i_estado = 1;
            $libro->i_imprime = 0;
            $libro->i_sisgen = 0;
        });

    }

    public function scopeFiltros(Builder $query, $search)
    {

        if ($search) {
            return $query
                ->Where('s_libro', 'LIKE', '%' . $search . '%')
                ->orWhere('s_numero_libro', 'LIKE', '%' . $search . '%')
                ->orWhere('s_forma', 'LIKE', '%' . $search . '%')
                ->orWhere('s_folios', 'LIKE', '%' . $search . '%')
                ->orWhere('s_codigo', 'LIKE', '%' . $search . '%')
                ->orWhereHas('empresa', function ($qr) use ($search) {
                    return $qr->Where('s_nombre', 'LIKE', '%' . $search . '%')
                        ->orWhere('s_num_doc', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('representante', function ($qr) use ($search) {
                    return $qr->NombreCompuesto($search)
                        ->orWhere('s_num_doc', 'LIKE', '%' . $search . '%');
                });
        }
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_empresa');
    }

    public function getSolicitanteAttribute()
    {
        $cliente = Cliente::where('s_codigo', $this->s_cliente)->active()->first();
        return is_object($cliente) ? $cliente : Empresa::where('s_codigo', $this->s_cliente)->active()->first();

    }

    public function facturado(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_facturar');
    }

    public function representante(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_representante');
    }

    protected function imprime(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->i_imprime ? 'SI' : 'NO'
        );
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('i_estado', 1);
    }

    public function detalle_recibo(): HasOne
    {
        return $this->HasOne(DetalleRecibo::class, 's_referencia', 's_codigo')
            ->with('recibo_pago');
    }

    public function files(): HasMany
    {
        return $this->hasMany(LibroDocument::class, 'id_libro', 's_codigo');
    }
}
