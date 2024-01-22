<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    protected $table = 'banco';
    protected $primaryKey = 'id_cod';
    public $timestamps = false;

    protected $casts = [
        'i_estado' => 'int'
    ];

    protected $fillable = [
        's_cod_pdt',
        's_cod_cnl',
        's_nombre',
        's_abrev',
        'i_estado'
    ];

    public function scopeActive($query)
    {
     return $query->where('i_estado', 1);
    }

    public function scopeFiltros($query, $value)
    {
        if ($value) {
            return $query->where('s_nombre', 'LIKE', '%' . $value . '%')
                ->orWhere('s_abrev', 'LIKE', '%' . $value . '%');
        }
    }



    protected function sNombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }


    protected function sAbrev(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
    protected function sCodPdt(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function sCodCnl(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => $value ?? '',
            set: fn (string $value) => strtoupper($value),
        );
    }
}
