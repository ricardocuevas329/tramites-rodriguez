<?php

namespace App\Models\External\Extraprotocolar;

use App\Models\External\Auth\UserClientExternal;
use App\Models\External\Auth\UserCompanyExternal;
use App\Traits\PermissionTravelUtils;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * @property string $travel
 * @property int $id
 * @property Date date_ret
 * @property Date date_sal
 * @property int return
 * @property int type
 * @property int format
 * @property string line
 * @property string obervation
 * @property string route
 * @property int read
 * @property int id_user_read
 * @property Date date_read
 */
class PermisoViajeExternal extends Model
{

    use HasFactory, SoftDeletes, PermissionTravelUtils;

    protected $table = 'permiso_viaje_external';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
    ];

    protected $fillable = [
        'id_user_register',
        'travel' ,
        'date_ret' ,
        'date_sal' ,
        'return' ,
        'type' ,
        'format' ,
        'line' ,
        'obervation' ,
        'route' ,
        'transport' ,
        'read' ,
        'id_user_read' ,
        'date_read' ,
        'phone'
    ];
    protected $appends = ['tipo_viaje', 'tipo_transporte'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($permisoviaje) {
            $permisoviaje->id_user_register = Auth::user()->s_codigo;
        });
    }

    protected function line(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function travel(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ? strtoupper($this->getNameAloneComponay($value)) : '',
            set: fn (string $value) => strtoupper($this->getNameAloneComponay($value)),
        );
    }

    protected function tipoViaje(): Attribute
    {
        return Attribute::make(
            get: fn (): string =>  $this->getNameTipoTravelAs($this->type),
        );
    }

    protected function tipoTransporte(): Attribute
    {
        return Attribute::make(
            get: fn (): string =>  $this->getNameTransportAs( (int) $this->type),
        );
    }

    public function scopeMyRecords(Builder $query)
    {
        return $query->where('id_user_register', Auth::user()->s_codigo);
    }




    public function participantes(): HasMany
    {

        return $this->hasMany(PermisoViajeParticipantExternal::class,'id_permiso_viaje','id')
            ->with(['files'])
            ->limit(10);
    }



    public function usuario_cliente(): HasOne
    {
      return $this->hasOne(UserClientExternal::class, 's_codigo', 'id_user_register');
    }

    public function usuario_empresa(): HasOne
    {
        return $this->hasOne(UserCompanyExternal::class, 's_codigo', 'id_user_register');
    }
}
