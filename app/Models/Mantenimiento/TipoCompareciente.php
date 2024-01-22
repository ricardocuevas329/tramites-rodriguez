<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCompareciente extends Model
{
    use HasFactory;
    protected $table = 'tipo_comparecientes';
    protected $primaryKey = 's_codigo';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        's_codigo', 's_nombre', 's_codigo_sg', 's_tipo_pdt',  's_color', 's_clase', 'i_estado'
    ];
}
