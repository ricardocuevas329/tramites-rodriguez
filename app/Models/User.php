<?php

namespace App\Models;

use App\Models\Mantenimiento\AsignacionLaboral;
use App\Models\Mantenimiento\Distrito;
use App\Models\Mantenimiento\Nacionalidad;
use App\Models\Mantenimiento\TipoDocumento;
use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // Notifiable
    use  HasFactory, HasApiTokens, HasRoles, HasPermissions, GenerateCode;

    protected $table = "personal";
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $guard_name = 'sanctum';
    protected $fillable = [
        's_codigo',
        's_paterno',
        's_materno',
        's_nombres',
        's_nombre_seg',
        's_tipoDocu',
        's_numero',
        's_estadoCivil',
        'd_fechaNacimiento',
        's_sexo',
        's_nacionalidad',
        's_distrito',
        's_direccion',
        's_mail',
        's_telefono',
        's_celular',
        's_correo_tra',
        's_telefono_tra',
        's_celular_tra',
        's_anexo_tra',
        's_observacion',
        's_barra',
        'd_fecha_reg',
        's_personal_reg',
        's_user',
        's_pass',
        'i_estado',
        's_frase',
        's_foto_fondo'
    ];
    protected $appends = ['nombre_compuesto', 'id_tipo_documento', 'estado_civil'];
    protected $hidden = [
        's_pass'
    ];

    protected $casts = [
        's_pass' => 'hashed',
        'd_fecha_reg' => 'datetime:Y-m-d',
        'd_fechaNacimiento' => 'datetime:Y-m-d',
        'id_tipo_documento' => 'string',
        's_paterno' => 'string',
        's_materno' => 'string',
        's_nombres' => 'string',
        's_nombre_seg' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $cod = (new User())->generateCode((new User())->table, 's_codigo', 8, 'PE');
            $user->s_codigo = $cod;
            $user->i_estado = 1;
            $user->d_fecha_reg = date("Y-m-d H:i:s");
            $user->s_personal_reg = Auth::user()->s_codigo;
        });
    }

    public function scopeNotSuperAdmin($query)
    {
        return $query->where('s_user', '!=', 'superadmin');
    }

    public function scopeActives($query)
    {
        return $query->where('i_estado', 1);
    }

    public function scopeNombreCompuesto($query, $search)
    {
        if ($search) {
            $query->where(
                DB::raw(
                    "REPLACE(
                    CONCAT(
                        COALESCE(s_nombres,''),' ',
                        COALESCE(s_nombre_seg,''),' ',
                        COALESCE(s_paterno,''),' ',
                        COALESCE(s_materno,'')
                    ),
                '  ',' ')"
                ),
                'like',
                '%' . $search . '%'
            );
        }
    }

    public function scopeFiltros($query, $search)
    {
        if ($search) {
            return $query->NombreCompuesto($search)
                ->orWhere('s_numero', 'LIKE', '%' . $search . '%')
                ->orWhere('s_codigo', 'LIKE', '%' . $search . '%')
                ->orWhere('s_direccion', 'LIKE', '%' . $search . '%')
                ->orWhere('s_celular', 'LIKE', '%' . $search . '%')
                ->orWhere('s_user', 'LIKE', '%' . $search . '%')
                ->orWhere('s_mail', 'LIKE', '%' . $search . '%');
        }
    }


    protected function EstadoCivil(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->s_estadoCivil ?? '',
        );
    }

    protected function sNombres(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value): string => strtoupper($value),
        );
    }

    protected function sNombreSeg(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string|null $value): string => strtoupper($value),
        );
    }


    protected function sPaterno(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value): string => strtoupper($value),
        );
    }


    protected function sMaterno(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string|null $value): string => strtoupper($value),
        );
    }

    protected function sMail(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value): string => strtoupper($value),
        );
    }


    protected function iEstado(): Attribute
    {
        return Attribute::make(
            get: fn($value): int => $value,
        );
    }


    public function getAuthPassword()
    {
        return $this->s_pass;
    }

    public function getAuthIdentifier()
    {
        return 's_codigo';
    }

    public function getNombreCompuestoAttribute(): string
    {
        return $this->s_nombres . ' ' . $this->s_nombre_seg . ' ' . $this->s_paterno . ' ' . $this->s_materno;
    }

    public function getIdTipoDocumentoAttribute(): string
    {
        return (string)$this->s_tipoDocu;
    }


    public static function checkDisabled($user)
    {
        return User::where('s_user', $user)->where('i_estado', 0)->first();
    }


    public function ubigeo(): HasOne
    {
        return $this->hasOne(Distrito::class, 's_codigo', 's_distrito');
    }


    public function nacionalidad(): HasOne
    {
        return $this->hasOne(Nacionalidad::class, 's_codigo', 's_nacionalidad')->where('i_estado', 1);
    }

    public function tipo_documento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 's_codigo', 's_tipoDocu')
            ->select('s_abrev', 's_codigo')->where('i_estado', 1);
    }

    public function asignacionLaboral(): HasMany
    {
        return $this->hasMany(AsignacionLaboral::class, 's_personal', 's_codigo');
    }
}
