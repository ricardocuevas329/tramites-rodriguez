<?php

namespace App\Models\Administracion;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
/**
 * Class Accione
 *
 * @property int $i_codigo
 * @property string|null $s_codper
 * @property string|null $s_nombre
 * @property string|null $s_descripcion
 * @property string|null $s_objeto
 * @property Carbon|null $d_fecha_reg
 * @property string|null $s_personal_reg
 * @property Carbon|null $d_fecha_mod
 * @property string|null $s_personal_mod
 * @property int|null $i_estado
 *
 * @package App\Models\Administracion
 */
class Accion extends Model
{
    protected $table = 'acciones';
	protected $primaryKey = 'i_codigo';
	public $timestamps = false;

	protected $casts = [
		'd_fecha_reg' => 'datetime',
		'd_fecha_mod' => 'datetime',
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_codper',
		's_nombre',
		's_descripcion',
		's_objeto',
		'd_fecha_reg',
		's_personal_reg',
		'd_fecha_mod',
		's_personal_mod',
		'i_estado'
	];

    public function scopeFiltros($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%')
			  ->OrWhere('s_descripcion', 'LIKE', '%'.$value.'%');
          }
    }


}
