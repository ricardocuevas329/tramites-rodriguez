<?php

namespace App\Models\Entidad;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * Class Abogado
 *
 * @property string $s_codigo
 * @property string|null $s_paterno
 * @property string|null $s_materno
 * @property string|null $s_nombres
 * @property string|null $s_sexo
 * @property string|null $s_telefono
 * @property string|null $s_cal
 * @property string|null $s_colegio
 * @property string|null $s_personal
 * @property int|null $i_estado
 *
 * @package App\Models\Entidad
 */

class Abogado extends Model
{

	protected $table = 'abogado';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int',
	];

	protected $fillable = [
        's_codigo',
		's_paterno',
		's_materno',
		's_nombres',
		's_sexo',
		's_telefono',
		's_cal',
		's_colegio',
		's_personal',
		'i_estado'
	];


    public function personal(): HasOne
    {
        return $this->hasOne(User::class, 's_codigo', 's_personal')
        ->select('s_nombres','s_codigo');
    }

    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->Where('s_codigo', 'LIKE', '%' . $search . '%')
                ->orWhere('s_paterno', 'LIKE', '%' . $search . '%')
                ->orWhere('s_materno', 'LIKE', '%' . $search . '%')
                ->orWhere('s_nombres', 'LIKE', '%' . $search . '%')
                ->orWhere('s_telefono', 'LIKE', '%' . $search . '%');
        }
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

    protected function sColegio(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sSexo(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function scopeNombre($query, $value)
    {
          if($value){
              return $query->where('s_nombres', 'LIKE', '%'.$value.'%');
          }
    }


    protected function iEstado(): Attribute
    {
        return Attribute::make(
            get: fn ($value): int => $value,
        );
    }


    public static function checkDisabled($abogado)
    {
        return Abogado::where('s_codigo',$abogado)->where('i_estado', 0)->first();
    }

}
