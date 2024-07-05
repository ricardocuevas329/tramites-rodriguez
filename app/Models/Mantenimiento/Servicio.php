<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicio
 *
 * @property string $s_nombre
 * @property string $s_descripcion
 * @property string $s_generico
 * @property int $i_formato
 * @property int $i_rapidos
 * @property int $i_estado
 * @package App\Models\Mantenimiento
 */
class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        's_codigo',
		's_nombre',
		's_descripcion',
		's_generico',
        'i_formato',
        'i_rapidos',
		'i_estado'
	];

    public function scopeActive($query)
    {
         return $query->where('i_estado', 1);
    }

    public function scopeFast($query)
    {
        return $query->where('i_rapidos', 1);
    }

    public function scopeNombre($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%');
          }
    }

    public function scopeFiltros(Builder $query, $search)
    {
        if ($search) {
            return $query->Where('s_nombre', 'LIKE', '%' . $search . '%')
                ->orWhere('s_descripcion', 'LIKE', '%' . $search . '%')
                ->orWhere('s_generico', 'LIKE', '%' . $search . '%');
        }
    }


}
