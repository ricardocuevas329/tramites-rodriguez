<?php

namespace App\Models\Extraprotocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Mantenimiento\Situacion;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * Class Carta
 *
 * @property string $s_carta
 * @property string $s_codigo
 * @property int|null $s_numcarta
 * @property string|null $s_acto_notarial
 * @property string|null $s_servicio
 * @property string|null $s_remitente
 * @property string|null $s_empresa
 * @property string|null $s_facturado
 * @property Carbon|null $d_fecha
 * @property string|null $s_hora
 * @property Carbon|null $d_fecha_cierre
 * @property string|null $s_destinatario
 * @property string|null $s_localidad
 * @property string|null $s_direccioncarta
 * @property string|null $s_atendido
 * @property Carbon|null $d_fechaEntrega
 * @property string|null $s_horaEntrega
 * @property string|null $s_N1
 * @property string|null $s_N2
 * @property string|null $s_N3
 * @property string|null $s_N4
 * @property string|null $s_descripcion
 * @property string|null $s_observacion
 * @property string|null $s_entregado
 * @property string|null $s_mensajero
 * @property string|null $s_recogido
 * @property Carbon|null $d_fechaRegogido
 * @property int|null $i_cantidad
 * @property float|null $de_precio
 * @property string|null $s_horaRecogido
 * @property int|null $i_tipopago
 * @property int|null $i_delivery
 * @property int|null $i_bajopuerta
 * @property int|null $i_urgente
 * @property int|null $i_situacion
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class Carta extends Model
{
    protected $table = 'cartas';
	protected $primaryKey = 's_carta';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		's_numcarta' => 'int',
		'd_fecha' => 'datetime',
		'd_fecha_cierre' => 'datetime',
		'd_fechaEntrega' => 'datetime',
		'd_fechaRegogido' => 'datetime',
		'i_cantidad' => 'int',
		'de_precio' => 'float',
		'i_tipopago' => 'int',
		'i_delivery' => 'int',
		'i_bajopuerta' => 'int',
		'i_urgente' => 'int',
		'i_situacion' => 'int',
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_codigo',
        's_carta',
		's_numcarta',
		's_acto_notarial',
		's_servicio',
		's_remitente',
		's_empresa',
		's_facturado',
		'd_fecha',
		's_hora',
		'd_fecha_cierre',
		's_destinatario',
		's_localidad',
		's_direccioncarta',
		's_atendido',
		'd_fechaEntrega',
		's_horaEntrega',
		's_N1',
		's_N2',
		's_N3',
		's_N4',
		's_descripcion',
		's_observacion',
		's_entregado',
		's_mensajero',
		's_recogido',
		'd_fechaRegogido',
		'i_cantidad',
		'de_precio',
		's_horaRecogido',
		'i_tipopago',
		'i_delivery',
		'i_bajopuerta',
		'i_urgente',
		'i_situacion',
		'i_estado'
	];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($carta) {
            $ultimo = Carta::latest('s_numcarta')->first();
            $carta->i_estado = 1;
            $carta->s_acto_notarial = "AN985";
            $carta->s_servicio = "SE134";
            $carta->d_fecha = date("Y-m-d");
            $carta->s_hora = date("H:i:s");
            $carta->i_cantidad = 1;
            $carta->s_atendido = Auth::user()->s_codigo;
			$carta->s_numcarta = $ultimo->s_numcarta + 1;
        });
    }


    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->Where('s_codigo', 'LIKE', '%' . $search . '%')
                ->orWhere('s_carta', 'LIKE', '%' . $search . '%')
                ->orWhere('s_numcarta', 'LIKE', '%' . $search . '%')
                ->orWhere('s_acto_notarial', 'LIKE', '%' . $search . '%')
                ->orWhere('s_descripcion', 'LIKE', '%' . $search . '%')
                ->orWhere('s_observacion', 'LIKE', '%' . $search . '%')
                ->orWhereHas('diligenciaCarta.personal', function($qr) use ($search){
                    return $qr->Filtros($search);
                });

        }
    }

    public function remitenteCliente(): HasMany
    {
        return $this->hasMany(Cliente::class,'s_codigo','s_remitente')
        ->whereRaw("LEFT(s_codigo, 2) = 'CL'");

    }

    public function referenteCliente(): HasMany
    {
        return $this->hasMany(Cliente::class,'s_codigo','s_empresa')
        ->whereRaw("LEFT(s_codigo, 2) = 'CL'");

    }

    public function remitenteEmpresa(): HasMany
    {
        return $this->hasMany(Empresa::class,'s_codigo','s_remitente')
        ->whereRaw("LEFT(s_codigo, 2) != 'CL'");
    }


    public function empresaEmpresa(): HasMany
    {
        return $this->hasMany(Empresa::class,'s_codigo','s_empresa')
        ->whereRaw("LEFT(s_codigo, 2) != 'CL'");
    }

    public function facturadoEmpresa(): HasMany
    {
        return $this->hasMany(Empresa::class,'s_codigo','s_facturado')
        ->whereRaw("LEFT(s_codigo, 2) != 'CL'");
    }

    public function facturadoCliente(): HasMany
    {
        return $this->hasMany(Cliente::class,'s_codigo','s_facturado')
        ->whereRaw("LEFT(s_codigo, 2) = 'CL'");

    }

    public function situacion(): HasOne
    {
        return $this->HasOne(Situacion::class,'i_codigo','i_situacion');
    }

    public function diligenciaCarta(): HasOne
    {
        return $this->HasOne(DiligenciaCarta::class,'s_num_carta','s_numcarta');
    }
}
