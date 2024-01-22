<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    use HasFactory;
    protected $table = 'requisitos';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [ 's_codigo', 's_nombre', 's_descripcion', 'i_estado'	];


    public function scopeSNombre($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%');
        }
    }

    public function scopeSDescripcion($query, $value)
    {
        if ($value) {
            return $query->where('s_descripcion', 'LIKE', '%' . $value . '%');
        }
    }
}
