<?php

 namespace App\Models\ExtraProtocolar;

use App\Models\Entidad\Cliente;
use App\Models\Mantenimiento\Condicion;
use App\Models\Mantenimiento\TipoDocumento;
use App\Traits\PermissionTravelUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use App\Enums\ParticipantItems;
/**
 * Class Participante
 *
 * @property int $i_codigo
 * @property int|null $i_permiso
 * @property int|null $i_condicion
 * @property string|null $s_participante
 * @property int|null $i_firma
 * @property string|null $s_edad
 * @property string|null $s_partida
 * @property string|null $s_sede_reg
 * @property string|null $s_observacion
 * @property Carbon|null $d_fecha_reg
 * @property string|null $s_personal_reg
 * @property Carbon|null $d_fecha_mod
 * @property string|null $s_personal_mod
 * @property int|null $i_estado
 *
 * @package App\Models\Extraprotocolar
 */
class Participante extends Model
{
	use PermissionTravelUtils;
	protected $table = 'participantes';
	protected $primaryKey = 'i_codigo';
	public $timestamps = false;

	protected $casts = [
		'd_fecha_reg' => 'datetime:Y-m-d',
        'd_fecha_mod' => 'datetime:Y-m-d',
		'i_permiso' => 'int',
		'i_condicion' => 'int',
		'i_firma' => 'int',
		'i_estado' => 'int'
	];

	protected $fillable = [
		'i_codigo',
		'i_permiso',
		'i_condicion',
		's_participante',
		'i_firma',
		's_edad',
		's_partida',
		's_sede_reg',
		's_observacion',
		'd_fecha_reg',
		's_personal_reg',
		'd_fecha_mod',
		's_personal_mod',
		'i_estado'
	];

	protected $appends = ['participa_como'];

	protected static function boot()
    {
        parent::boot();
        static::creating(function ($permisoviaje) {
            $permisoviaje->i_estado = 1;
            $permisoviaje->d_fecha_reg = date("Y-m-d H:i:s");
            $permisoviaje->s_personal_reg = Auth::user()->s_codigo;
        });

		static::updating(function ($permisoviaje) {
            $permisoviaje->d_fecha_mod = date("Y-m-d H:i:s");
            $permisoviaje->s_personal_mod = Auth::user()->s_codigo;
        });
    }

	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_observacion', 'LIKE', '%' . $value . '%');
        }
    }

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }

    public function scopeParticipantActive($query)
    {
        return $query->active()->where(function ($qr) {
            $qr->where('i_condicion', '!=', ParticipantItems::ACOMPANANTE);
        });
    }

    public function scopeAcompananteActive($query)
    {
        return $query->active()->where(function ($qr) {
            $qr->where('i_condicion', ParticipantItems::ACOMPANANTE);
        });
    }


    protected function participaComo(): Attribute
    {
        return Attribute::make(
            get: fn (): string =>  $this->getNameParticipatesAs($this->i_condicion),
        );
    }




    public function tipo_documento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 's_codigo', 's_tipoDocu')
            ->select('s_abrev', 's_codigo')
            ->where('i_estado', 1);
    }

    public function oficina_registral(): HasOne
    {
        return $this->hasOne(OficinaRegistral::class, 's_codigo', 's_sede_reg')
            ->where('i_estado', 1);
    }


    public function condicion(): HasOne
    {
        return $this->hasOne(Condicion::class, 's_codigo', 'i_condicion')
            ->where('estado', 1);
    }

	public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_participante')
            ->where('i_estado', 1)
            ->with(['nacionalidad','tipo_documento','ubigeo']);
    }


}
