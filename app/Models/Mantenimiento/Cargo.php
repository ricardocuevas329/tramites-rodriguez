<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargo';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_estado' => 'int'
	];

	protected $fillable = [ 's_codigo', 's_nombre', 's_descripcion', 'i_estado'	];



     public function scopeFiltros($query, $value)
     {
         if ($value) {
             return $query->where('s_descripcion', 'LIKE', '%' . $value . '%')
             ->orWhere('s_nombre', 'LIKE', '%' . $value . '%');
         }
     }

 

 

    protected function descripcion(): Attribute 
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
    
    protected function iEstado(): Attribute 
    {
        return Attribute::make(
            get: fn ($value): int => $value,
        );
    }
    
 
    public static function checkDisabled($cargos)
    {
        return Cargo::where('codigo', $cargos)->where('i_estado', 0)->first();
    }
}
