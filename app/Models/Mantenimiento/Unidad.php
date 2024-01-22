<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{

    protected $table = 'unidades';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [
        's_codigo',
		's_nombre',
		's_abrev',
		's_observacion',
		'i_estado'
	];
 
}
