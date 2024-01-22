<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionLaboral extends Model
{
    use HasFactory;
    protected $table = 'asignacion_laboral';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [ 's_codigo', 's_personal', 's_cargo', 's_area', 's_seccion', 'd_fecha_ing', 'i_estado'	];

}
