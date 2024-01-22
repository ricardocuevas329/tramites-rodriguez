<?php

namespace App\Models\Entidad;

use App\Models\Mantenimiento\Distrito;
use App\Models\Mantenimiento\Nacionalidad;
use App\Models\Mantenimiento\TipoDocumento;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ClientExternal
 *
 * @property string $s_codigo
 * @property string|null $s_paterno
 * @property string|null $s_materno
 * @property string|null $s_nombres
 * @property string|null $s_tipoDocu
 * @property string|null $s_num_doc
 * @property Carbon|null $d_fecha_nac
 * @property string|null $s_estado_civil
 * @property string|null $s_nacionalidad
 * @property string|null $s_localidad
 * @property string|null $s_direccion
 * @property string|null $s_referencia
 * @property string|null $s_sexo
 * @property string|null $s_correo
 * @property string|null $s_telefono
 * @property string|null $s_celular
 * @property string|null $s_pass
 * @property string|null $s_profesion
 * @property string|null $s_otro_profesion
 * @property string|null $s_cargo
 * @property string|null $s_otro_cargo
 * @property int|null $i_residencia
 * @property Carbon|null $d_fecha_reg
 * @property string|null $s_personal_reg
 * @property Carbon|null $d_fecha_mod
 * @property string|null $s_personal_mod
 * @property int|null $i_estado
 *
 * @package App\Models\Entidad
 */
class Cliente extends Model
{
    use HasFactory, GenerateCode;

    protected $table = 'cliente';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['nombre_compuesto', 'id_tipo_documento', 'correo', 'nombre'];
    protected $casts = [
        'd_fecha_nac' => 'datetime:Y-m-d',
        'i_residencia' => 'int',
        'd_fecha_reg' => 'datetime',
        'd_fecha_mod' => 'datetime',
        'i_estado' => 'int',
        'nombre_compuesto' => 'string',
        'id_tipo_documento' => 'string'
    ];
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
        //'s_pass',
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


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cliente) {
            $cod = (new Cliente())->generateCode((new Cliente())->table, 's_codigo', 10, 'CL');
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

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }


    public function scopeNombreCompuesto($query, $value)
    {
        if ($value) {
            return $query->WhereRaw("CONCAT_WS(' ', COALESCE(s_nombres, ''), COALESCE(s_paterno, ''), COALESCE(s_materno, '')) LIKE ?", ['%' . $value . '%']);
        }

    }


    public function scopeFilters($query, $value)
    {
        if ($value) {
            return $query->NombreCompuesto($value)
                ->orWhere('s_num_doc', 'LIKE', '%' . $value . '%')
                ->orWhere('s_celular', 'LIKE', '%' . $value . '%')
                ->orWhere('s_correo', 'LIKE', '%' . $value . '%')
                ->orWhere('s_telefono', 'LIKE', '%' . $value . '%')
                ->orWhere('s_codigo', 'LIKE', '%' . $value . '%');
        }
    }


    protected function nombreCompuesto(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->s_nombres . ' ' . $this->s_paterno . ' ' . $this->s_materno,
        );
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn(): string|null => $this->s_nombres,
        );
    }

    protected function correo(): Attribute
    {
        return Attribute::make(
            get: fn(): string|null => $this->s_correo,
        );
    }

    protected function IdTipoDocumento(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->s_tipoDocu ?? ''
        );
    }


    protected function sNombres(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value) => strtoupper($value),
        );
    }

    protected function sPaterno(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string $value) => strtoupper($value),
        );
    }

    protected function sMaterno(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string|null $value) => $value ? strtoupper($value) : '',
        );
    }

    protected function sDireccion(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => $value ?? '',
            set: fn(string| null $value) => $value ? strtoupper($value) : '' ,
        );
    }


    public function tipo_documento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 's_codigo', 's_tipoDocu')
            ->select('s_abrev', 's_codigo','s_nombre');
    }


    public function ubigeo(): HasOne
    {
        return $this->hasOne(Distrito::class, 's_codigo', 's_localidad');
    }


    public function nacionalidad(): HasOne
    {
        return $this->hasOne(Nacionalidad::class, 's_codigo', 's_nacionalidad');
    }

    public function scopeDocumento($query, $tipo_doc, $num_doc)
    {
        if ($tipo_doc && $num_doc) {
            return $query->whereRaw("MATCH(s_tipoDocu) AGAINST(? IN BOOLEAN MODE)", [$tipo_doc])
                ->whereRaw("MATCH(s_num_doc) AGAINST(? IN BOOLEAN MODE)", [$num_doc]);
        }
    }

    protected function sPass(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Hash::make(trim($value))
        );
    }


}
