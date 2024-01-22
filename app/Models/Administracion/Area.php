<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Area
 *
 * @property string $s_codigo
 * @property string|null $s_nombre
 * @property string|null $s_descarea
 * @property int|null $i_estado
 *
 * @package App\Models\Administracion
 */
class Area extends Model
{
    use HasFactory;

    protected $table = 'area';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [
        's_codigo',
		's_nombre',
		's_descarea',
		'i_estado'
	];

    public function scopeFiltros($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%')
              ->orWhere('s_descarea', 'LIKE', '%'.$value.'%');
          }
    }



    protected function sNombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sDescarea(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
}
