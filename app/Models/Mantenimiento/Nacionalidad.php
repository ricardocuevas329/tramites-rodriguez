<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
	protected $table = 'nacionalidad';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_codigo',
		's_pais',
		's_gentilicio',
		's_codigo_sbs',
		'i_estado'
	];

	public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_pais', 'LIKE', '%' . $value . '%')
                ->orWhere('s_gentilicio', 'LIKE', '%' . $value . '%');
        }
    }

    public function scopeActives($query)
    {
        if ($query) {
            return $query->where('i_estado', 1);
        }
    }
}
