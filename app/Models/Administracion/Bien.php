<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;
    protected $table = 'bienes';
	protected $primaryKey = 's_codigo';
	public $incrementing = false;
	public $timestamps = false;
    protected $appends = [
		'descripcion'
	];
	protected $casts = [
		'i_estado' => 'int',
        's_nombre' => 'string',
        's_decripcion' => 'string',
        'descripcion' => 'string'
	];

	protected $fillable = [
		's_nombre',
		's_decripcion',
		'i_estado'
	];

    public function scopeSNombre($query, $value)
    {
          if($value){
              return $query->where('s_nombre', 'LIKE', '%'.$value.'%');
          }
    }

   public function scopeSDescripcion($query, $value)
    {
          if($value){
              return $query->orWhere('s_decripcion', 'LIKE', '%'.$value.'%');
          }
    }

    

    protected function sNombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sDecripcion(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
 
    public function getDescripcionAttribute(): string
    {
        return $this->s_decripcion;
    }
    
   
}
