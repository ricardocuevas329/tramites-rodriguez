<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoPago extends Model
{
    use HasFactory;
    protected $table = 'modopago';
    protected $primaryKey = 'i_codigo';
    public $timestamps = false;
    protected $fillable = [
        's_codigo_pdt', 's_codigo_sbs', 's_nombre',  's_descripcion', 'i_estado'
    ];
}
