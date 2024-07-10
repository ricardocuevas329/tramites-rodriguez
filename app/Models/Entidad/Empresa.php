<?php

namespace App\Models\Entidad;

use App\Models\ExtraProtocolar\OficinaRegistral;
use App\Models\Mantenimiento\Distrito;
use App\Models\Mantenimiento\Estado;
use App\Models\Mantenimiento\Nacionalidad;
use App\Models\Mantenimiento\TipoDocumento;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class Empresa
 *
 * @property string $s_codigo
 * @property string|null $s_nombre
 * @property string|null $s_tip_doc
 * @property string|null $s_num_doc
 * @property int|null $i_nacionalidad
 * @property string|null $s_localidad
 * @property string|null $s_direccion
 * @property string|null $s_referencia
 * @property string|null $s_email
 * @property string|null $s_web
 * @property string|null $s_telefono
 * @property string|null $s_celular
 * @property string|null $s_oficina
 * @property string|null $s_partida
 * @property string|null $s_registro
 * @property string|null $s_ciiu
 * @property string|null $s_objeto_social
 * @property string|null $s_anotacion
 * @property string|null $s_pass
 * @property Carbon|null $d_fecha_reg
 * @property string|null $s_personal_reg
 * @property Carbon|null $d_fecha_mod
 * @property string|null $s_personal_mod
 * @property int|null $i_estado
 *
 * @package App\Models\Entidad
 */
class Empresa extends Model
{
    use HasFactory, GenerateCode;
    protected $table = 'empresa';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;
    protected $appends = ['nombre_compuesto', 'correo', 'nombre'];

	protected $casts = [
		'i_nacionalidad' => 'int',
		'd_fecha_reg' => 'datetime',
		'd_fecha_mod' => 'datetime',
		'i_estado' => 'int'
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
            $cod = (new Empresa())->generateCode((new Empresa())->table, 's_codigo', 10, 'EP');
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

    public function scopeActive($query)
    {
       return $query->where('i_estado', 1);
    }

    public function scopeFilterNames($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%')
                ->orWhere('s_num_doc',  $value );
        }
    }

    public function scopeFilters($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%')
                ->orWhere('s_num_doc',  $value )
				->orWhere('s_direccion', 'LIKE', '%' . $value . '%')
				->orWhere('s_celular', $value )
				->orWhere('s_email', 'LIKE', '%' . $value . '%');
        }
    }

    protected function correo(): Attribute
    {
        return Attribute::make(
            get: fn(): string|null => $this->s_email,
        );
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn(): string|null => $this->s_nombre,
        );
    }

    protected function sNombre(): Attribute
    {
        return Attribute::make(
			get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sDireccion(): Attribute
    {
        return Attribute::make(
			get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function nacionalidad(): HasOne
    {
        return $this->hasOne(Nacionalidad::class, 's_codigo', 'i_nacionalidad');
    }

	public function tipo_documento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 's_codigo', 's_tip_doc')
        ->select('s_abrev','s_codigo');
    }

    protected function sPass(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make(trim($value))
        );
    }

    protected function nombreCompuesto(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->s_nombre,
        );
    }

    public function scopeDocumento($query, $tipo_doc, $num_doc)
    {
        if($tipo_doc && $num_doc){
            return $query->where('s_tip_doc', $tipo_doc)->where('s_num_doc',$num_doc);
        }
    }

    public function distrito(): HasOne
    {
        return $this->hasOne(Distrito::class, 's_codigo', 's_localidad');
    }

    public function estado(): HasOne
    {
        return $this->hasOne(Estado::class, 'i_codigo', 's_registro')->select('i_codigo','s_desc');
    }

    public function oficina_registral(): HasOne
    {
        return $this->hasOne(OficinaRegistral::class, 's_codigo', 's_oficina')->select('s_codigo','s_nombre');
    }

}
