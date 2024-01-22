<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{

    protected $table = 'profesion';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'i_tipo' => 'int',
		'i_estado' => 'int'
	];

	protected $fillable = [
		's_codigo_sbs',
		's_nombre',
		's_nombref',
		'i_tipo',
		's_descripcion',
		'i_estado'
	];


     public function scopeSNombre($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%');
          }
    }


    protected function sNombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
    protected function sNombref(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sDescripcion(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string|null $value) => $value ?? strtoupper($value),
        );
    }



    protected function iEstado(): Attribute
    {
        return Attribute::make(
            get: fn ($value): int => $value,
        );
    }


    public static function checkDisabled(string $profesion)
    {
        return Profesion::where('s_codigo',$profesion)->where('i_estado', 0)->first();
    }
}
