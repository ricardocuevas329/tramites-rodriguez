<?php

namespace App\Models\Protocolar;

use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Models\Mantenimiento\Estado;
use App\Models\User;
use App\Traits\GenerateCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Kardex
 *
 * @property string $s_codigo
 * @property string|null $s_tipokardex
 * @property string|null $s_kardex
 * @property string|null $s_actnot
 * @property string|null $s_compareciente
 * @property string|null $s_referente
 * @property string|null $s_facturar
 * @property string|null $d_feching
 * @property string|null $s_horaing
 * @property string|null $s_atendido
 * @property string|null $s_responsable
 * @property string|null $s_digitado
 * @property Carbon|null $d_fecha_digitado
 * @property string|null $s_impreso
 * @property Carbon|null $d_fecha_impreso
 * @property string|null $s_confrontador
 * @property string|null $s_confrontador_seg
 * @property Carbon|null $d_fecha_confrontado
 * @property string|null $d_fechcalificada
 * @property string|null $d_fechminuta
 * @property string|null $i_numminuta
 * @property int|null $i_minuta_usuario
 * @property string|null $d_fechescritura
 * @property int|null $i_numescritura
 * @property string|null $s_opcion_escritura
 * @property string|null $d_fechparte
 * @property string|null $s_personal_parte
 * @property string|null $d_fechtestimonio
 * @property string|null $s_personal_testimonio
 * @property string|null $s_kardexconex
 * @property string|null $s_abogado
 * @property string|null $s_personal_abogado
 * @property Carbon|null $d_fecha_abogado
 * @property string|null $s_anno
 * @property int|null $i_numfol
 * @property int|null $i_folini
 * @property int|null $i_foliniV
 * @property int|null $i_folfin
 * @property int|null $i_folfinV
 * @property int|null $i_serini
 * @property int|null $i_serieiniV
 * @property int|null $i_serfin
 * @property int|null $i_seriefinV
 * @property string|null $s_numtom
 * @property string|null $s_numreg
 * @property string|null $i_numeroOperacion
 * @property string|null $s_obstitulo
 * @property string|null $s_tipo_tramite
 * @property string|null $s_num_solicitud
 * @property string|null $d_fecha_solicitud
 * @property string|null $i_estadonota
 * @property string|null $d_fechbajakardex
 * @property string|null $s_personal_baja
 * @property int|null $i_sisgen
 * @property int|null $i_estado
 *
 * @package App\Models\Protocolar
 */
class Kardex extends Model
{
    use GenerateCode;
    protected $table = 'kardex';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['num_kardex'];
    protected $casts = [
        'd_fechtestimonio' => 'datetime:d/m/y',
        'd_fecha_digitado' => 'datetime',
        'd_fecha_impreso' => 'datetime',
        'd_fecha_confrontado' => 'datetime',
        'i_minuta_usuario' => 'int',
        'i_numescritura' => 'int',
        'd_fecha_abogado' => 'datetime',
        'i_numfol' => 'int',
        'i_folini' => 'int',
        'i_foliniV' => 'int',
        'i_folfin' => 'int',
        'i_folfinV' => 'int',
        'i_serini' => 'int',
        'i_serieiniV' => 'int',
        'i_serfin' => 'int',
        'i_seriefinV' => 'int',
        'i_sisgen' => 'int',
        'i_estado' => 'int',
        'd_feching' => 'date: d/m/Y',
        'd_fechescritura' => 'date: d/m/Y',
    ];

    protected $fillable = [
        's_tipokardex',
        's_kardex',
        's_actnot',
        's_compareciente',
        's_referente',
        's_facturar',
        'd_feching',
        's_horaing',
        's_atendido',
        's_responsable',
        's_digitado',
        'd_fecha_digitado',
        's_impreso',
        'd_fecha_impreso',
        's_confrontador',
        's_confrontador_seg',
        'd_fecha_confrontado',
        'd_fechcalificada',
        'd_fechminuta',
        'i_numminuta',
        'i_minuta_usuario',
        'd_fechescritura',
        'i_numescritura',
        's_opcion_escritura',
        'd_fechparte',
        's_personal_parte',
        'd_fechtestimonio',
        's_personal_testimonio',
        's_kardexconex',
        's_abogado',
        's_personal_abogado',
        'd_fecha_abogado',
        's_anno',
        'i_numfol',
        'i_folini',
        'i_foliniV',
        'i_folfin',
        'i_folfinV',
        'i_serini',
        'i_serieiniV',
        'i_serfin',
        'i_seriefinV',
        's_numtom',
        's_numreg',
        'i_numeroOperacion',
        's_obstitulo',
        's_tipo_tramite',
        's_num_solicitud',
        'd_fecha_solicitud',
        'i_estadonota',
        'd_fechbajakardex',
        's_personal_baja',
        'i_sisgen',
        'i_estado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payload) {
            $cod = (new Kardex())->generateCode((new Kardex())->table, 's_codigo', 12, 'OS');
            $payload->s_codigo = $cod;
            $payload->i_estado = 1;
        });

    }

    protected function sKardex(): Attribute
    {
        return Attribute::make(
            get: fn($value): int => $value
        );
    }

    protected function numKardex(): Attribute
    {
        return Attribute::make(
            get: fn(): int => $this->s_kardex
        );
    }

    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_kardex', $value)
                ->orWhere('s_obstitulo', 'LIKE', '%' . $value . '%');
        }
    }

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }


    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 's_codigo', 's_compareciente')->select('s_codigo', 's_nombres', 's_paterno', 's_materno');
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 's_codigo', 's_compareciente')->select('s_codigo', 's_nombre');
    }

    public function asesor(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_atendido')->select('s_codigo', 's_nombres', 's_paterno', 's_materno');
    }

    public function estado(): HasOne
    {
        return $this->hasOne(Estado::class, 'i_codigo', 'i_estadonota')->select('i_codigo', 's_desc');
    }

    public function participantes(): HasMany
    {
        return $this->HasMany(Interviniente::class, 's_kardex', 's_codigo');
    }

    public function participantes_firmados(): HasMany
    {
        return $this->HasMany(Interviniente::class, 's_kardex', 's_codigo')
            ->where('i_firma', 1)
            ->where('s_compareciente', 'like', 'CL%')
            ->whereNotNull('d_fechfirma')
            ->orderBy('d_fechfirma', 'desc');
    }

}
