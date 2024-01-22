<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CargoPublico extends Model
{

    protected $table = 'cargos';
	protected $primaryKey = 'codigo';
	public $incrementing = false;
	public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'codigo',  'descripcion', 'i_estado'
    ];



    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function scopeSNombre($query, $value)
    {
        if ($value) {
            return $query->where('descripcion', 'LIKE', '%' . $value . '%');
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
            get: fn ($value): int => $value
        );
    }
    

    public static function checkDisabled($cargos)
    {
        return CargoPublico::where('codigo', $cargos)->where('i_estado', 0)->first();
    }
}
