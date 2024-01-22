<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;
    protected $table = 'distrito1';
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;

    protected $appends = ['distrito','provincia','departamento','ubigeo_compuesto'];


    public function getDistritoAttribute(): string
    {
        return trim($this->s_distrito);
    }



    public function getUbigeoCompuestoAttribute(): string
    {
        return $this->departamento.'|'.$this->provincia.'|'.trim($this->s_distrito);
    }

    protected function sDistrito(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function getProvinciaAttribute(): string
    {
        $data = Provincia::where('s_codigo',substr($this->s_codigo, 0, 4))->first();
        return trim($data?->s_provincia);
    }

    public function getDepartamentoAttribute(): string
    {
        $data = Departamento::where('s_codigo',substr($this->s_codigo, 0, 2))->first();
        return trim($data?->s_departamento);
    }

    public function scopeNombre($query, $value)
    {
          if($value){
              return $query->where('s_distrito', 'LIKE', '%'.$value.'%');
          }
    }


}
