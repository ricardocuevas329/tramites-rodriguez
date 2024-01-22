<?php
namespace App\Models\External\Auth;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserClientExternal extends Authenticatable  implements MustVerifyEmail
{
    use  Notifiable, HasFactory, HasApiTokens, GenerateCode;
    protected $table = "cliente";
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $guard_name = 'sanctum-client';

    protected $appends = ['nombre_compuesto'];

    protected $fillable = [
        's_codigo',
        's_paterno',
        's_materno',
        's_nombres',
        's_tipoDocu',
        's_num_doc',
        'd_fecha_nac',
        's_estado_civil',
        's_nacionalidad',
        's_localidad',
        's_direccion',
        's_referencia',
        's_sexo',
        's_correo',
        's_telefono',
        's_celular',
        's_pass',
        's_profesion',
        's_otro_profesion',
        's_cargo',
        's_otro_cargo',
        'i_residencia',
        'd_fecha_reg',
        's_personal_reg',
        'd_fecha_mod',
        's_personal_mod',
        'i_estado'
    ];

    protected $hidden = [
        's_pass'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cliente) {
            $cod = (new UserClientExternal())->generateCode((new UserClientExternal())->table, 's_codigo', 10, 'CL');
            $cliente->s_codigo = $cod;
            $cliente->i_estado = 1;
            $cliente->d_fecha_reg = date("Y-m-d H:i:s");
            $cliente->s_personal_reg = Auth::user()?->s_codigo;
        });

        static::updating(function ($cliente) {
            $cliente->d_fecha_mod = date("Y-m-d H:i:s");
            $cliente->s_personal_mod = Auth::user()?->s_codigo;
        });
    }

    public function routeNotificationForMail($notification)
    {
        return $this->s_correo;

    }

    public static function checkDisabled(string $email)
    {
        return UserClientExternal::where('s_correo', $email)->where('i_estado', 0)->first();
    }

    public function getNombreCompuestoAttribute(): string
    {
        return $this->s_nombres. ' ' . $this->s_paterno . ' ' . $this->s_materno;
    }

    public function getAuthPassword()
    {
        return $this->s_pass;
    }

    public function getAuthIdentifier()
    {
        return 's_codigo';
    }


    protected function sNombres(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) =>  strtoupper($value),
        );
    }

    protected function sPaterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) =>   strtoupper($value),
        );
    }

    protected function sMaterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) =>  strtoupper($value),
        );
    }


    protected function sPass(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make(trim($value))
        );
    }
}
