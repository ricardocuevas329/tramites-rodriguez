<?php

namespace App\Models\Protocolar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistroPublico extends Model
{
    use HasFactory;

    protected $table = 'registros_publicos';
    protected $primaryKey = 's_codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'i_estado' => 'int'
    ];

    protected $fillable = [
        'i_estado',
        's_tive',
        's_kardex',
        'd_fecha',
        's_hora',
        's_partida',
        'de_pagado',
        's_orden',
        'd_fecha_registro',
        's_oficina',
        's_codigo',
        's_area',
        's_usuario_modificacion',
        's_descargo',
        'd_fecha_plazo',
        'd_fecha_modificacion',
        's_personal_registro',
        's_asiento',
        's_titulo',
        's_estadoR',
        's_tipo_pago',
    ];

    public function scopeActive($query)
    {
        return $query->where('i_estado', 1);
    }



    public function kardex(): HasMany
    {
        return $this->HasMany(Kardex::class, 's_codigo', 's_kardex');
    }
}
