<?php

namespace App\Models\External\Auth;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserCompanyExternal extends Authenticatable
{
    use  HasFactory, HasApiTokens, GenerateCode;
    protected $table = "empresa";
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $guard_name = 'sanctum-company';
    protected $appends = ['nombre_compuesto'];

    protected $hidden = [
        's_pass'
    ];
    protected $fillable = [
        's_codigo',
        's_nombre',
        's_tip_doc',
        's_num_doc',
        'i_nacionalidad',
        's_localidad',
        's_direccion',
        's_referencia',
        's_email',
        's_web',
        's_telefono',
        's_celular',
        's_oficina',
        's_partida',
        's_registro',
        's_ciiu',
        's_objeto_social',
        's_anotacion',
        's_pass',
        'd_fecha_reg',
        's_personal_reg',
        'd_fecha_mod',
        's_personal_mod',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($empresa) {
            $cod = (new UserCompanyExternal())->generateCode((new UserCompanyExternal())->table, 's_codigo', 10, 'EP');
            $empresa->s_codigo = $cod;
            $empresa->i_estado = 1;
            $empresa->d_fecha_reg = date("Y-m-d H:i:s");
            $empresa->s_personal_reg = Auth::user()?->s_codigo;
        });

        static::updating(function ($empresa) {
            $empresa->d_fecha_mod = date("Y-m-d H:i:s");
            $empresa->s_personal_mod = Auth::user()?->s_codigo;
        });
    }

    public function routeNotificationForMail($notification)
    {
        return $this->s_email;

    }
    public function getNombreCompuestoAttribute(): string
    {
        return $this->s_nombre;
    }
    public static function checkDisabled(string $email)
    {
        return UserCompanyExternal::where('s_email', $email)->where('i_estado', 0)->first();
    }



    public function getAuthPassword()
    {
        return $this->s_pass;
    }

    public function getAuthIdentifier()
    {
        return 's_codigo';
    }

    protected function sNombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }


    protected function sPass(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make(trim($value))
        );
    }

}
