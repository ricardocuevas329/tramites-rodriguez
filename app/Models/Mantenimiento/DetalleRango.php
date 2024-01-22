<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetalleRango extends Model
{
    protected $table = 'detalle_rango';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;


	protected $fillable = [
        's_codigo',
		's_servicios',
		's_colum1',
		's_colum2',
		'de_precio'
	];

    public function scopeFiltros($query, $value)
     {
         if ($value) {
             return $query->where('s_colum2', 'LIKE', '%' . $value . '%');
         }
     }


}
