<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    use HasFactory;
    protected $table = 'tipo_cambio';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'de_compra' => 'float',
		'de_venta' => 'float',
		'd_fecha_reg' => 'datetime',
		'd_fecha_mod' => 'datetime',
		'i_estado' => 'int'
	];

	protected $fillable = [
		'de_compra',
		'de_venta',
		'd_fecha_reg',
		's_personal_reg',
		'd_fecha_mod',
		's_personal_mod',
		'i_estado'
	];
    
    public function scopeDFecha($query, $value)
    {
          if($value){
              return $query->where('d_fecha', 'LIKE', '%'.$value.'%');
          }
    }
        
}
