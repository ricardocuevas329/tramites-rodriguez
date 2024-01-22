<?php

namespace App\Models\ExtraProtocolar;

use App\Models\User;
use App\Traits\PermissionTravelUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;


/**
 * Class PermisoViaje
 *
 * @property int $i_codigo
 * @property Carbon|null $d_fecha_ins
 * @property int|null $i_numero
 * @property int|null $i_tipo
 * @property Carbon|null $d_fecha_sal
 * @property Carbon|null $d_fecha_ret
 * @property string|null $s_transporte
 * @property string|null $s_linea
 * @property string|null $s_ruta
 * @property int|null $i_retorno
 * @property string|null $s_observacion
 * @property string|null $s_hijo
 * @property string|null $s_edad
 * @property int|null $i_solo
 * @property string|null $s_formato
 * @property Carbon|null $d_fecha_reg
 * @property string|null $s_personal_reg
 * @property Carbon|null $d_fecha_mod
 * @property string|null $s_personal_mod
 * @property int|null $i_estado
 *
 * @package App\Models\ExtraProtocolar\Extraprotocolar
 */
class PermisoViaje extends Model
{
    use PermissionTravelUtils;

    protected $table = 'permiso_viaje';
    protected $primaryKey = 'i_codigo';
    public $timestamps = false;
    protected $appends = ['tipo_viaje', 'tipo_transporte'];
    protected $casts = [
        'd_fecha_reg' => 'datetime:d/m/Y',
        'd_fecha_mod' => 'datetime:Y-m-d',
        'd_fecha_ins' => 'datetime:Y-m-d',
        'i_numero' => 'int',
        'i_tipo' => 'int',
        'd_fecha_sal' => 'datetime:Y-m-d',
        'd_fecha_ret' => 'datetime:Y-m-d',
        'i_retorno' => 'int',
        'i_solo' => 'int',
        'i_estado' => 'int'
    ];

    protected $fillable = [
        'i_codigo',
        'd_fecha_ins',
        'i_numero',
        'i_tipo',
        'd_fecha_sal',
        'd_fecha_ret',
        's_transporte',
        's_linea',
        's_ruta',
        'i_retorno',
        's_observacion',
        's_hijo',
        's_edad',
        'i_solo',
        's_formato',
        'd_fecha_reg',
        's_personal_reg',
        'd_fecha_mod',
        's_personal_mod',
        'i_estado'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($permisoviaje) {
            $permisoviaje->i_estado = 1;
            $permisoviaje->d_fecha_reg = date("Y-m-d H:i:s");
            $permisoviaje->s_personal_reg = Auth::user()->s_codigo;
            $permisoviaje->d_fecha_ins = date("Y-m-d");
        });

        static::updating(function ($permisoviaje) {
            $permisoviaje->d_fecha_mod = date("Y-m-d H:i:s");
            $permisoviaje->s_personal_mod = Auth::user()->s_codigo;
        });
    }

    public function scopeMyRecords(Builder $query)
    {
        return $query->where('s_personal_reg', Auth::user()->s_codigo);
    }

    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->where(function ($qr) use ($search) {
                $qr->where('s_edad', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_formato', 'LIKE', '%' . $search . '%')
                    ->orWhere('i_numero', 'LIKE', '%' . $search . '%')
                    ->orWhere('s_observacion', 'LIKE', '%' . $search . '%');
            });
         }
    }


    public function scopeSearchClient(Builder $query, $search)
    {
        if ($search) {
            return $query->orWhereHas('participantes.cliente', function (Builder $q) use ($search) {
                return $q->where('s_nombres', 'LIKE', '%' . $search . '%');
            });
        }
    }

    protected function sRuta(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string|null $value): string => $value ? strtoupper($value) : '',
        );
    }

    protected function sLinea(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string|null $value): string => $value ? strtoupper($value) : '',
        );
    }


    protected function tipoViaje(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getNameTipoTravelAs($this->i_tipo),
        );
    }

    protected function tipoTransporte(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getNameTransportAs((int)$this->s_transporte),
        );
    }

    protected function soloAcompanado(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getNameAloneComponay((int)$this->i_solo),
        );
    }

    protected function retorno(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getNameRetorno((int)$this->i_solo),
        );
    }

    protected function formato(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getNameFormats((int)$this->s_formato),
        );
    }


    public function participantes(): HasMany
    {
        return $this->hasMany(Participante::class, 'i_permiso', 'i_codigo')
            ->ParticipantActive()
            ->with('cliente');
    }


    public function usuario(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_personal_reg');
    }

    public function acompanantes(): HasMany
    {
        return $this->hasMany(Participante::class, 'i_permiso', 'i_codigo')
            ->AcompananteActive()
            ->with('cliente');
    }

    public function files(): HasMany
    {
        return $this->hasMany(PermisoViajeDocument::class, 'id_permiso_viaje', 'i_codigo');
    }
}
