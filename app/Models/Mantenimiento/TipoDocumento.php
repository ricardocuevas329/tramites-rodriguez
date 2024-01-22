<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    protected $table = 'tipo_docu';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false; 

    public function scopeNombre($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%');
          }
    }

   public function scopeAbreviatura($query, $value)
    {
          if($value){
              return $query->orWhere('s_abrev', 'LIKE', '%'.$value.'%');
          }
    }

    public function scopeActivos($query)
    {
      return $query->where('i_estado', 1);
    }

    
      
    protected function s_nombre(): Attribute|string
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }
    protected function s_abrev(): Attribute|string
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function getIDigitosAttribute($value)
    {
       return (int) $value;
    } 
    

}
