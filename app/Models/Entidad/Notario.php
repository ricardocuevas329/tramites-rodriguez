<?php

namespace App\Models\Entidad;

use App\Models\Mantenimiento\TipoDocumento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * Class Notario
 *
 * @property string $s_codigo
 * @property string|null $s_tipodoc
 * @property string|null $s_numdoc
 * @property string|null $s_paterno
 * @property string|null $s_materno
 * @property string|null $s_nombres
 * @property string|null $s_cargo
 * @property string|null $s_sexo
 * @property string|null $s_telefonos
 * @property string|null $s_observacion
 * @property int|null $i_estado
 *
 * @package App\Models\Entidad
 */
class Notario extends Model
{
    use HasFactory;
    protected $table = 'notario';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;
    protected $appends = ['nombre_compuesto'];
	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [
        's_codigo',
		's_tipodoc',
		's_numdoc',
		's_paterno',
		's_materno',
		's_nombres',
		's_cargo',
		's_sexo',
		's_telefonos',
		's_observacion',
		'i_estado'
	];
    public function scopeNombreCompuesto($query, $search)
    {
        if ($search) {
            $query->where(
                DB::raw(
                    "REPLACE(
                    CONCAT(
                        COALESCE(s_nombres,''),' ',
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
    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->NombreCompuesto($search)
                ->orWhere('s_codigo', 'LIKE', '%' . $search . '%')
                ->orWhere('s_numdoc', 'LIKE', '%' . $search . '%')
                ->orWhere('s_telefonos', 'LIKE', '%' . $search . '%')
                ->orWhere('s_observacion', 'LIKE', '%' . $search . '%');
        }
    }
    public function getNombreCompuestoAttribute(): string
    {
        return $this->s_nombres . ' ' . $this->s_paterno . ' ' . $this->s_materno;
    }

	protected function sNombres(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sPaterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sMaterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function tipo_documento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 's_codigo', 's_tipodoc')
            ->select('s_abrev', 's_codigo');
    }

}

