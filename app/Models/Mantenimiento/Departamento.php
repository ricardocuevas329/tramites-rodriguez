<?php

namespace App\Models\Mantenimiento;

use App\Traits\GenerateCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory, GenerateCode;
    protected $table = 'departamento1';
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['s_departamento'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($departamento) {
            $cod =  self::orderBy('s_codigo', 'desc')->first();
            if ($cod) {
                $contador =  (int)$cod->s_codigo + 1;
            } else {
                $contador = 1;
            }
            $codigo = str_pad($contador, 2, '0', STR_PAD_LEFT);
            $departamento->s_codigo = $codigo;
        });

    }

    public function scopeFiltros($query, $value)
    {
          if($value){
              return $query->where('s_departamento', 'LIKE', '%'.$value.'%');
          }
    }



    protected function sDepartamento(): Attribute
    {
        return Attribute::make(
            set: fn (string $value):string => strtoupper($value),
        );
    }


}

