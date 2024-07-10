<?php

namespace App\Models\Protocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany};
use Illuminate\Support\Facades\Auth;

/**
 * Class Presencia
 *
 * @property string $s_codigo
 * @property string|null $s_contacto
 * @property string|null $s_referente
 * @property string|null $s_facturado
 * @property Carbon|null $d_fecha_registro
 * @property string|null $s_hora_registro
 * @property string|null $s_atendido
 * @property int|null $i_tipopago
 * @property string|null $s_observacion
 * @property int|null $i_estado
 *
 * @package App\Models
 */
class Presencia extends Model
{
    use GenerateCode;

    protected $table = 'presencias';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'd_fecha_registro' => 'datetime:d/m/Y',
        'i_tipopago' => 'int',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_contacto',
        's_referente',
        's_facturado',
        'd_fecha_registro',
        's_hora_registro',
        's_atendido',
        'i_tipopago',
        's_observacion',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $cod = (new Presencia())->generateCode((new Presencia())->table, 's_codigo', 12, 'PS');
            $payload->s_codigo = $cod;
            $payload->i_estado = 1;
            $payload->s_atendido = Auth::user()->s_codigo;
            $payload->d_fecha_registro = date('Y-m-d');
            $payload->s_hora_registro = date('H:i:s');
        });

    }

    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->WhereHas('contacto_cliente', function (Builder $q) use ($value) {
                return $q->NombreCompuesto($value);
            })->orWhereHas('contacto_empresa', function (Builder $q) use ($value) {
                return $q->FilterNames($value);
            })->orWhereHas('facturado_cliente', function (Builder $q) use ($value) {
                return $q->NombreCompuesto($value);
            })->orWhereHas('facturado_empresa', function (Builder $q) use ($value) {
                return $q->FilterNames($value);
            })->orWhereHas('referente_cliente', function (Builder $q) use ($value) {
                return $q->NombreCompuesto($value);
            })->orWhereHas('referente_empresa', function (Builder $q) use ($value) {
                return $q->FilterNames($value);
            });
        }
    }

    public function scopeMyRecords($query)
    {
        return $query->where('s_atendido', Auth::user()->s_codigo);
    }


    public function contacto_cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_contacto')
            ->select('s_codigo', 's_nombres', 's_paterno', 's_materno', 's_direccion');
    }

    public function contacto_empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_contacto')
            ->select('s_codigo', 's_nombre', 's_direccion');
    }

    public function facturado_cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_facturado')
            ->select('s_codigo', 's_nombres', 's_paterno', 's_materno', 's_direccion');
    }

    public function facturado_empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_facturado')
            ->select('s_codigo', 's_nombre', 's_direccion');
    }

    public function referente_cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_referente')
            ->select('s_codigo', 's_nombres', 's_paterno', 's_materno', 's_direccion');
    }

    public function referente_empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_referente')
            ->select('s_codigo', 's_nombre', 's_direccion');
    }

    public function atendido(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_atendido');
    }


    public function detalle(): HasMany
    {
        return $this->hasMany(DetallePresencia::class, 's_referencia', 's_codigo');
    }

    public function detalle_procurador(): HasOne
    {
        return $this->hasOne(DetalleProcurador::class, 's_presencia', 's_codigo');
    }

}
