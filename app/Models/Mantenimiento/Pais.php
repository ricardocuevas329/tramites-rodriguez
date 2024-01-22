<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\AsStringable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\String_;

class Pais extends Model
{
	protected $table = 'paises';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int',
		's_pais' =>  AsStringable::class,
		's_gentilicio_m' => 'string',
		's_gentilicio_f' => 'string'
	];

	protected $fillable = [
		's_codigo',
		's_pais',
		's_gentilicio_m',
		's_gentilicio_f',
		'i_estado'
	];

	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_pais', 'LIKE', '%' . $value . '%')
                ->orWhere('s_gentilicio_m', 'LIKE', '%' . $value . '%')
				->orWhere('s_gentilicio_f', 'LIKE', '%' . $value . '%');
        }
    }

	protected function spais(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
			get: fn (string $value) => (string) $value,
        );
    }

	protected function sgentiliciom(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

	protected function sgentiliciof(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }
}