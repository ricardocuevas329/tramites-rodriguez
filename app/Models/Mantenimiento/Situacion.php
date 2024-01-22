<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situacion extends Model
{
    use HasFactory;
    protected $table = 'situacion';
    protected $primaryKey = 'i_codigo';
    public $timestamps = false;

    protected $fillable = [
        'i_codigo',
		's_tipo',
		's_nombre',
		'i_estado'
	];
}
