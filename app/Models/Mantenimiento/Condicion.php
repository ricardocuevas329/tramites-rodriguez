<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Condicion
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $id_cnl
 * @property int|null $estado
 *
 * @package App\Models\Extraprotocolar
 */
class Condicion extends Model
{
    use HasFactory;
    protected $table = 'condicion';
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'nombre',
		'id_cnl',
		'estado'
	];
    public function scopeNombre($query, $value)
    {
          if($value){
              return $query->where('nombre', 'LIKE', '%'.$value.'%');
          }
    }



    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }


}
