<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'provincia1';
    protected $primaryKey = "s_codigo";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        's_codigo',  's_provincia'
      ];
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
            $codigo = str_pad($contador, 4, '0', STR_PAD_LEFT);
            $departamento->s_codigo = $codigo;
        });

    }

    public function scopeDepartamento($query, $value)
    {
          if($value){
              return $query->where(DB::raw('LEFT (s_codigo, 2)'),  $value);
          }
    }


    protected function sProvincia(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => strtoupper($value),
        );
    }


}
